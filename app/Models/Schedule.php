<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['class_id', 'subject_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time'];

    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id'); }
    public function subject() { return $this->belongsTo(Subject::class, 'subject_id', 'subject_id'); }
    public function teacher() { return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id'); }
    public function attendances() { return $this->hasMany(Attendance::class, 'schedule_id', 'schedule_id'); }
}
