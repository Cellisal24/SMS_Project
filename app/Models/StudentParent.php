<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'student_parents';
    protected $fillable = ['student_id', 'parent_id', 'relationship', 'is_primary'];
}
