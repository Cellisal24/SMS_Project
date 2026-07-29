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
    protected $fillable = ['teacher_id', 'first_name', 'last_name', 'gender', 'email', 'contact_number', 'photo'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($teacher) {
            if (empty($teacher->teacher_id)) {
                $teacher->teacher_id = static::generateNextId();
            }
        });
    }

    public static function generateNextId(): string
    {
        $last = self::orderByDesc('teacher_id')->first();
        $next = $last ? ((int) substr($last->teacher_id, 3)) + 1 : 1;

        return 'TCH' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function schedules() { return $this->hasMany(Schedule::class, 'teacher_id', 'teacher_id'); }
    public function user() { return $this->hasOne(User::class, 'teacher_id', 'teacher_id'); }
}