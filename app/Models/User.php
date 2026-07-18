<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'password_hash', 'role', 'student_id', 'teacher_id'];

    // ប្រាប់ Laravel ថា password ក្នុង DB ឈ្មោះ password_hash
    public function getAuthPassword() { return $this->password_hash; }

    public function student() { return $this->belongsTo(Student::class, 'student_id', 'student_id'); }
    public function teacher() { return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id'); }
    public function activityLogs() { return $this->hasMany(ActivityLog::class, 'user_id', 'user_id'); }
    public function notifications() { return $this->hasMany(Notification::class, 'sender_user_id', 'user_id'); }
}