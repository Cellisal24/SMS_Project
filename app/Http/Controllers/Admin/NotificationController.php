<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::query();

        if ($request->filled('recipient_type')) {
            $query->where('recipient_type', $request->recipient_type);
        }

        $notifications = $query->latest('sent_at')->paginate(20)->withQueryString();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_type' => ['required', 'in:student,teacher,parent,admin,all'],
            'recipient_id'   => ['nullable', 'string', 'max:20'], // ignored when recipient_type is "all"
            'title'          => ['required', 'string', 'max:100'],
            'body'           => ['nullable', 'string'],
        ]);

        $recipients = $this->resolveRecipients($validated['recipient_type'], $validated['recipient_id'] ?? null);

        foreach ($recipients as $recipientId) {
            Notification::create([
                'sender_user_id' => auth()->id(),
                'recipient_type' => $validated['recipient_type'] === 'all' ? 'all' : $validated['recipient_type'],
                'recipient_id'   => $recipientId,
                'title'          => $validated['title'],
                'body'           => $validated['body'] ?? null,
                'sent_at'        => now(),
            ]);
        }

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification sent to ' . count($recipients) . ' recipient(s).');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification deleted.');
    }

    /**
     * Resolve which recipient_id values to write one notification row for.
     * "all" fans out to every ID in that role's table.
     */
    private function resolveRecipients(string $type, ?string $specificId): array
    {
        if ($specificId) {
            return [$specificId];
        }

        return match ($type) {
            'student' => Student::pluck('student_id')->all(),
            'teacher' => Teacher::pluck('teacher_id')->all(),
            'parent' => ParentModel::pluck('parent_id')->all(),
            default => [],
        };
    }
    public function markRead(Request $request)
{
    $userId = (string) auth()->id();

    Notification::where(function ($q) use ($userId) {
        $q->where('recipient_type', 'admin')->where('recipient_id', $userId);
    })->orWhere('recipient_type', 'all')
      ->whereNull('read_at')
      ->update(['read_at' => now()]);

    return back();
}
}
