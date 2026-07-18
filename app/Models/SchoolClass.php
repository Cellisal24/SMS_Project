<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['class_id', 'class_name', 'level_id', 'room_id', 'academic_year'];

    public function gradeLevel() { return $this->belongsTo(GradeLevel::class, 'level_id', 'level_id'); }
    public function students() { return $this->hasMany(Student::class, 'class_id', 'class_id'); }
    
}
