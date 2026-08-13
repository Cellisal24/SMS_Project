<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('student');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_id', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->input('status') === 'outstanding') {
            $query->whereColumn('amount_paid', '<', 'total_fee');
        } elseif ($request->input('status') === 'paid') {
            $query->whereColumn('amount_paid', '>=', 'total_fee');
        }

        $payments = $query->latest('payment_date')->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayment($request);
        $validated['invoice_id'] = 'INV-' . strtoupper(Str::random(8));

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment record created successfully.');
    }

    public function edit(Payment $payment)
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $this->validatePayment($request);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment record updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment record deleted.');
    }

    private function validatePayment(Request $request): array
    {
        return $request->validate([
            'student_id'    => ['required', 'string', 'exists:students,student_id'],
            'description'   => ['nullable', 'string', 'max:100'],
            'total_fee'     => ['required', 'numeric', 'min:0'],
            'discount'      => ['nullable', 'numeric', 'min:0'],
            'amount_paid'   => ['required', 'numeric', 'min:0'],
            'payment_date'  => ['required', 'date'],
        ]);
    }
}
