<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('Admin.dashboard');
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
