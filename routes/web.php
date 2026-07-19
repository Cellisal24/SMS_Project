<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SubjectController;
use Illuminate\Support\Facades\Route;

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





Route::get('/dashboard-parent', [DashboardController::class, 'dashboardParent'])->name('dashboard-parent');

Route::get('/dashboard-teacher', [DashboardController::class, 'dashboardTeacher'])->name('dashboard-teacher');

Route::get('/dashboard-student', [DashboardController::class, 'dashboardStudent'])->name('dashboard-student');

