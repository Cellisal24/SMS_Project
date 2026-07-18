<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['teacher_id', 'first_name', 'last_name', 'gender', 'email', 'contact_number'];

    public function schedules() { return $this->hasMany(Schedule::class, 'teacher_id', 'teacher_id'); }
    public function user() { return $this->hasOne(User::class, 'teacher_id', 'teacher_id'); }
}
