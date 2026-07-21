<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
     use HasFactory, \App\Models\Concerns\HasStudentLinks;
     
    protected $table = 'parents';
    protected $primaryKey = 'parent_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['parent_id', 'first_name', 'last_name', 'phone', 'email', 'national_id'];

    public function students() {
        return $this->belongsToMany(Student::class, 'student_parents', 'parent_id', 'student_id');
    }
}
