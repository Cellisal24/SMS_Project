<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\SchoolClassController;

use App\Http\Controllers\Admin\StudentParentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamResultController;
use App\Http\Controllers\Teacher\ScheduleController as TeacherScheduleController;
use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Student\ScheduleController as StudentScheduleController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Admin Dashboard


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Grade Levels
    Route::get('/grade-levels', [GradeLevelController::class, 'index'])->name('grade-levels.index');
    Route::get('/grade-levels/create', [GradeLevelController::class, 'create'])->name('grade-levels.create');
    Route::post('/grade-levels', [GradeLevelController::class, 'store'])->name('grade-levels.store');
    Route::get('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'show'])->name('grade-levels.show');
    Route::get('/grade-levels/{gradeLevel}/edit', [GradeLevelController::class, 'edit'])->name('grade-levels.edit');
    Route::put('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'update'])->name('grade-levels.update');
    Route::delete('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'destroy'])->name('grade-levels.destroy');

    // Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Subjects
    Route::get('/subjects', [SubjectController::class, 'index'])->name('admin.subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('admin.subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('admin.subjects.show');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('admin.subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::post('/students/{student}/reset-password', [StudentController::class, 'resetPassword'])->name('admin.students.reset-password');

    // School Classes
    Route::get('/school-classes', [SchoolClassController::class, 'index'])->name('school-classes.index');
    Route::get('/school-classes/create', [SchoolClassController::class, 'create'])->name('school-classes.create');
    Route::post('/school-classes', [SchoolClassController::class, 'store'])->name('school-classes.store');
    Route::get('/school-classes/{schoolClass}', [SchoolClassController::class, 'show'])->name('school-classes.show');
    Route::get('/school-classes/{schoolClass}/edit', [SchoolClassController::class, 'edit'])->name('school-classes.edit');
    Route::put('/school-classes/{schoolClass}', [SchoolClassController::class, 'update'])->name('school-classes.update');
    Route::delete('/school-classes/{schoolClass}', [SchoolClassController::class, 'destroy'])->name('school-classes.destroy');

    // Teachers
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::post('/teachers/{teacher}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');

    // Parents
    Route::get('/parents', [ParentController::class, 'index'])->name('admin.parents.index');
    Route::get('/parents/create', [ParentController::class, 'create'])->name('admin.parents.create');
    Route::post('/parents', [ParentController::class, 'store'])->name('admin.parents.store');
    Route::get('/parents/{parent}/edit', [ParentController::class, 'edit'])->name('admin.parents.edit');
    Route::put('/parents/{parent}', [ParentController::class, 'update'])->name('admin.parents.update');
    Route::delete('/parents/{parent}', [ParentController::class, 'destroy'])->name('admin.parents.destroy');
    Route::post('/parents/{parent}/reset-password', [ParentController::class, 'resetPassword'])->name('admin.parents.reset-password');

    // Student-Parents
    Route::get('/student-parents', [StudentParentController::class, 'index'])->name('admin.student_parents.index');
    Route::get('/student-parents/create', [StudentParentController::class, 'create'])->name('admin.student_parents.create');
    Route::post('/student-parents', [StudentParentController::class, 'store'])->name('admin.student_parents.store');
    Route::get('/student-parents/{studentParent}/edit', [StudentParentController::class, 'edit'])->name('admin.student_parents.edit');
    Route::put('/student-parents/{studentParent}', [StudentParentController::class, 'update'])->name('admin.student_parents.update');
    Route::delete('/student-parents/{studentParent}', [StudentParentController::class, 'destroy'])->name('admin.student_parents.destroy');


    // Schedules
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');

    //grades
    Route::get('/grades', [GradeController::class, 'index'])->name('admin.grades.index');
    Route::get('/grades/create', [GradeController::class, 'create'])->name('admin.grades.create');
    Route::get('/grades/roster', [GradeController::class, 'roster'])->name('admin.grades.roster');
    Route::post('/grades', [GradeController::class, 'store'])->name('admin.grades.store');
    Route::get('/grades/{grade}/edit', [GradeController::class, 'edit'])->name('admin.grades.edit');
    Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('admin.grades.update');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('admin.grades.destroy');

    //payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('admin.payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
     
    //notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])->name('admin.notifications.mark-read');

    //reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('admin.reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('admin.reports.store');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('admin.reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('admin.reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');
  
    //activity logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    Route::delete('/activity-logs/{activityLog}', [ActivityLogController::class, 'destroy'])->name('admin.activity-logs.destroy');
    Route::post('/activity-logs/purge', [ActivityLogController::class, 'purge'])->name('admin.activity-logs.purge');

    //profile & settings
    Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile.show');
    Route::get('/settings', [ProfileController::class, 'editSettings'])->name('admin.settings.edit');
    Route::put('/settings/password', [ProfileController::class, 'updatePassword'])->name('admin.settings.password');

     Route::get('/exams', [ExamController::class, 'index'])
            ->name('admin.exams.index');

        // Create Exam Form
        Route::get('/exams/create', [ExamController::class, 'create'])
            ->name('admin.exams.create');

        // Save Exam
        Route::post('/exams', [ExamController::class, 'store'])
            ->name('admin.exams.store');

        // Show Exam Detail (Optional)
        Route::get('/exams/{exam}', [ExamController::class, 'show'])
            ->name('admin.exams.show');

        // Edit Exam
        Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])
            ->name('admin.exams.edit');

        // Update Exam
        Route::put('/exams/{exam}', [ExamController::class, 'update'])
            ->name('admin.exams.update');

        // Delete Exam
        Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])
            ->name('admin.exams.destroy');

    // Exam Results List & Actions
    Route::get('exam-results', [ExamResultController::class, 'index'])->name('exam_results.index');
    Route::delete('exam-results/{examResult}', [ExamResultController::class, 'destroy'])->name('exam_results.destroy');

    // Enter Scores Routes
    Route::get('exams/{exam}/scores', [ExamResultController::class, 'enterScores'])->name('admin.exams.scores.enter');
    Route::post('exams/{exam}/scores', [ExamResultController::class, 'storeScores'])->name('admin.exams.scores.store');
});

// Attendance
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('admin.attendance.create');
    Route::get('/attendance/roster', [AttendanceController::class, 'roster'])->name('admin.attendance.roster');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
});

//teacher only
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/schedule', [TeacherScheduleController::class, 'index'])->name('teacher.schedule.index');

    Route::get('/grades', [TeacherGradeController::class, 'index'])->name('teacher.grades.index');
    Route::get('/grades/roster', [TeacherGradeController::class, 'roster'])->name('teacher.grades.roster');
    Route::post('/grades', [TeacherGradeController::class, 'store'])->name('teacher.grades.store');
});


//student
    Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    
    Route::get('/schedule', [StudentScheduleController::class, 'index'])->name('student.schedule.index');
    Route::get('/grades', [StudentGradeController::class, 'index'])->name('student.grades.index');

});



//authentication routes
// Public login — student / teacher / parent
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
});

// Admin login — separate, not linked from the public page
// Support case variants so /Admin/login does not return 404 on Windows or manual URL entry.
Route::redirect('/Admin/login', '/admin/login');
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->middleware('role:admin')
        ->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('role:admin');

    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])
        ->middleware('role:admin')->name('admin.dashboard');

    Route::get('/teacher/dashboard', [DashboardController::class, 'dashboardTeacher'])
        ->middleware('role:teacher')->name('teacher.dashboard');

    Route::get('/student/dashboard', [DashboardController::class, 'dashboardStudent'])
        ->middleware('role:student')->name('student.dashboard');

    Route::get('/parent/dashboard', [DashboardController::class, 'dashboardParent'])
        ->middleware('role:parent')->name('parent.dashboard');
});


