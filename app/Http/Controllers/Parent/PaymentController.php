<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $parent = auth()->user()->parentProfile()->firstOrFail();

        $myChildren = StudentParent::where('parent_id', $parent->parent_id)
            ->with('student')
            ->get()
            ->pluck('student');

        $childIds = $myChildren->pluck('student_id');

        $query = Payment::whereIn('student_id', $childIds)->with('student');

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $payments = $query->orderByDesc('payment_date')->paginate(20)->withQueryString();

        return view('Parent.payments.index', compact('payments', 'myChildren'));
    }
}