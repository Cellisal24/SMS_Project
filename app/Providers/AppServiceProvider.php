<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\GradeLevel;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Report;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Observers\ActivityLogObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);

        Student::observe(ActivityLogObserver::class);
        Teacher::observe(ActivityLogObserver::class);
        SchoolClass::observe(ActivityLogObserver::class);
        Subject::observe(ActivityLogObserver::class);
        GradeLevel::observe(ActivityLogObserver::class);
        Room::observe(ActivityLogObserver::class);
        Grade::observe(ActivityLogObserver::class);
        Attendance::observe(ActivityLogObserver::class);
        Payment::observe(ActivityLogObserver::class);
        Report::observe(ActivityLogObserver::class);

        View::composer('admin.include.header', function ($view) {
            if (! Auth::check()) {
                return;
            }

            $userId = (string) Auth::id();

            $query = Notification::where(function ($q) use ($userId) {
                $q->where('recipient_type', 'admin')->where('recipient_id', $userId);
            })->orWhere('recipient_type', 'all');

            $view->with('navNotifications', (clone $query)->orderByDesc('sent_at')->limit(5)->get());
            $view->with('navUnreadCount', (clone $query)->whereNull('read_at')->count());
        });
    }
}