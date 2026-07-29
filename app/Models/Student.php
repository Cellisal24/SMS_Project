<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, \App\Models\Concerns\HasParentLinks;
    
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['student_id', 'first_name', 'last_name', 'gender', 'date_of_birth', 'class_id', 'parent_phone', 'status','photo',];

    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id'); }
    public function parents() { return $this->belongsToMany(ParentModel::class, 'student_parents', 'student_id', 'parent_id'); }
    public function student_parents() { return $this->belongsToMany(StudentParent::class, 'student_parents', 'student_id', 'parent_id'); }
    public function attendances() { return $this->hasMany(Attendance::class, 'student_id', 'student_id'); }
    public function grades() { return $this->hasMany(Grade::class, 'student_id', 'student_id'); }
    public function payments() { return $this->hasMany(Payment::class, 'student_id', 'student_id'); }
    public function examResults() { return $this->hasMany(ExamResult::class, 'student_id', 'student_id'); }
    public function user() { return $this->hasOne(User::class, 'student_id', 'student_id'); }
    
}
