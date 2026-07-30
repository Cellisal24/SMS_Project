<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class AllNotificationController extends Controller
{
    public function index()
    {
        $notifications = $this->baseQuery()
            ->latest('sent_at')
            ->paginate(20);

        return view('shared.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $this->assertBelongsToUser($notification);

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllRead()
    {
        $this->baseQuery()->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Notifications belonging to the current user: either sent directly
     * to their specific ID, or broadcast to "all" of their role.
     */
    protected function baseQuery()
    {
        $user = auth()->user();
        $myId = match ($user->role) {
            'student' => $user->student_id,
            'teacher' => $user->teacher_id,
            'parent' => $user->parent_id,
            default => null,
        };

        return Notification::where(function ($q) use ($user, $myId) {
            $q->where(function ($sub) use ($user, $myId) {
                $sub->where('recipient_type', $user->role)
                    ->where('recipient_id', $myId);
            })->orWhere('recipient_type', 'all');
        });
    }

    protected function assertBelongsToUser(Notification $notification): void
    {
        $user = auth()->user();
        $myId = match ($user->role) {
            'student' => $user->student_id,
            'teacher' => $user->teacher_id,
            'parent' => $user->parent_id,
            default => null,
        };

        $isMine = ($notification->recipient_type === $user->role && $notification->recipient_id === $myId)
            || $notification->recipient_type === 'all';

        if (! $isMine) {
            abort(403);
        }
    }

    /**
     * Small helper for the header bell dropdown — latest 5 + unread count.
     */
    public static function forHeader(): array
    {
        if (! auth()->check()) {
            return ['items' => collect(), 'unreadCount' => 0];
        }

        $controller = new self();
        $query = $controller->baseQuery();

        return [
            'items' => (clone $query)->latest('sent_at')->take(5)->get(),
            'unreadCount' => (clone $query)->whereNull('read_at')->count(),
        ];
    }
}