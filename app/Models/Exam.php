<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $primaryKey = 'exam_id';
    protected $fillable = ['subject_id', 'class_id', 'room_id', 'semester', 'exam_date', 'start_time', 'end_time', 'academic_year'];

    public function subject() { return $this->belongsTo(Subject::class, 'subject_id', 'subject_id'); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id'); }
    public function room() { return $this->belongsTo(Room::class, 'room_id', 'room_id'); }
    public function examResults() { return $this->hasMany(ExamResult::class, 'exam_id', 'exam_id'); }
}
