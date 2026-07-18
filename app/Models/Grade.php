<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'grade_id';
    protected $fillable = ['student_id', 'subject_id', 'semester', 'midterm_score', 'final_score'];

    public function student() { return $this->belongsTo(Student::class, 'student_id', 'student_id'); }
    public function subject() { return $this->belongsTo(Subject::class, 'subject_id', 'subject_id'); }
}
