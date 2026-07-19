<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $subjectCount = Subject::count();
        $recentSubjects = Subject::latest('created_at')->take(5)->get();

        return view('Admin.dashboard', compact('subjectCount', 'recentSubjects'));
    }
    public function dashboardParent()
    {
        return view('Parent.dashboard-parent');
    }
    public function dashboardTeacher()
    {
        return view('Teacher.dashboardTeacher');
    }
    public function dashboardStudent()
    {
        return view('Student.dashboardStudent');
    }
}
