<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    protected $fillable = ['student_id', 'schedule_id', 'date', 'status', 'leave_reason'];

    public function student() { return $this->belongsTo(Student::class, 'student_id', 'student_id'); }
    public function schedule() { return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id'); }
}
