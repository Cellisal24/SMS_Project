<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('table_name')) {
            $query->where('table_name', $request->table_name);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('record_id', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$search}%"));
            });
        }

        $logs = $query->latest('created_at')->paginate(25)->withQueryString();

        $actions = ActivityLog::select('action')->distinct()->orderBy('action')->pluck('action');
        $tables = ActivityLog::select('table_name')->distinct()->orderBy('table_name')->pluck('table_name');

        return view('admin.activity_logs.index', compact('logs', 'actions', 'tables'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')->with('success', 'Log entry deleted.');
    }

    /**
     * Bulk-delete logs older than a cutoff date, for housekeeping.
     */
    public function purge(Request $request)
    {
        $data = $request->validate([
            'before_date' => ['required', 'date'],
        ]);

        $count = ActivityLog::whereDate('created_at', '<', $data['before_date'])->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "Purged {$count} log entr" . ($count === 1 ? 'y' : 'ies') . " older than {$data['before_date']}.");
    }
}
