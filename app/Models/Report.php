<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'student_id',
        'class_id',
        'semester',
        'academic_year',
        'total_score',
        'average_score',
        'class_rank',
        'attendance_percentage',
        'teacher_comments',
        'generated_by',
        'generated_at',
        'status',
    ];

    public function student() { return $this->belongsTo(Student::class, 'student_id', 'student_id'); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id'); }
    public function generatedBy() { return $this->belongsTo(Teacher::class, 'generated_by', 'teacher_id'); }
}