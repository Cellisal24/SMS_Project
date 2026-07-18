<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $table = 'grade_levels';
    protected $primaryKey = 'level_id';
    protected $fillable = ['level_name', 'stage', 'sort_order'];

    public function classes() {
        return $this->hasMany(SchoolClass::class, 'level_id', 'level_id');
    }
}
