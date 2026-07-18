<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['subject_id', 'subject_name', 'credit_hours', 'department'];

    public function schedules() { return $this->hasMany(Schedule::class, 'subject_id', 'subject_id'); }
    public function grades() { return $this->hasMany(Grade::class, 'subject_id', 'subject_id'); }
    public function exams() { return $this->hasMany(Exam::class, 'subject_id', 'subject_id'); }
}
