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
Route::get('/dashboard-admin', [DashboardController::class, 'dashboard'])->name('dashboard-admin');

//Grade Level Routes
Route::get('/grade-levels', [GradeLevelController::class, 'index'])->name('grade-levels.index');
Route::get('/grade-levels/create', [GradeLevelController::class, 'create'])->name('grade-levels.create');
Route::post('/grade-levels', [GradeLevelController::class, 'store'])->name('grade-levels.store');
Route::get('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'show'])->name('grade-levels.show');
Route::get('/grade-levels/{gradeLevel}/edit', [GradeLevelController::class, 'edit'])->name('grade-levels.edit');
Route::put('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'update'])->name('grade-levels.update');
Route::delete('/grade-levels/{gradeLevel}', [GradeLevelController::class, 'destroy'])->name('grade-levels.destroy');

//Room Routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');          // បង្ហាញបញ្ជី និង Search/Filter
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');   // បង្ហាញផ្ទាំងបង្កើតថ្មី
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');          // ទទួលទិន្នន័យទៅរក្សាទុក (Insert)
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');      // បង្ហាញព័ត៌មានលម្អិតបន្ទប់មួយ
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit'); // បង្ហាញផ្ទាំងកែប្រែទិន្នន័យ
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');  // ទទួលទិន្នន័យកែប្រែទៅបច្ចុប្បន្នភាព (Update)
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy'); // លុបទិន្នន័យ (Delete)

//Subject Routes
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
// School Classes Routes
Route::get('/school-classes', [SchoolClassController::class, 'index'])->name('school-classes.index');
Route::get('/school-classes/create', [SchoolClassController::class, 'create'])->name('school-classes.create');
Route::post('/school-classes', [SchoolClassController::class, 'store'])->name('school-classes.store');
Route::get('/school-classes/{schoolClass}', [SchoolClassController::class, 'show'])->name('school-classes.show');
Route::get('/school-classes/{schoolClass}/edit', [SchoolClassController::class, 'edit'])->name('school-classes.edit');
Route::put('/school-classes/{schoolClass}', [SchoolClassController::class, 'update'])->name('school-classes.update');
Route::delete('/school-classes/{schoolClass}', [SchoolClassController::class, 'destroy'])->name('school-classes.destroy');
//Teacher Routes
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
// Parents
Route::get('/parents', [ParentController::class, 'index'])->name('admin.parents.index');
Route::get('/parents/create', [ParentController::class, 'create'])->name('admin.parents.create');
Route::post('/parents', [ParentController::class, 'store'])->name('admin.parents.store');
Route::get('/parents/{parent}/edit', [ParentController::class, 'edit'])->name('admin.parents.edit');
Route::put('/parents/{parent}', [ParentController::class, 'update'])->name('admin.parents.update');
Route::delete('/parents/{parent}', [ParentController::class, 'destroy'])->name('admin.parents.destroy');

//StudentParents
Route::get('/student-parents', [StudentParentController::class, 'index'])->name('admin.student_parents.index');
Route::get('/student-parents/create', [StudentParentController::class, 'create'])->name('admin.student_parents.create');
Route::post('/student-parents', [StudentParentController::class, 'store'])->name('admin.student_parents.store');
Route::get('/student-parents/{studentParent}/edit', [StudentParentController::class, 'edit'])->name('admin.student_parents.edit');
Route::put('/student-parents/{studentParent}', [StudentParentController::class, 'update'])->name('admin.student_parents.update');
Route::delete('/student-parents/{studentParent}', [StudentParentController::class, 'destroy'])->name('admin.student_parents.destroy');


Route::get('/dashboard-parent', [DashboardController::class, 'dashboardParent'])->name('dashboard-parent');

Route::get('/dashboard-teacher', [DashboardController::class, 'dashboardTeacher'])->name('dashboard-teacher');

Route::get('/dashboard-student', [DashboardController::class, 'dashboardStudent'])->name('dashboard-student');



