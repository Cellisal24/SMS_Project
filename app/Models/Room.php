<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    public $incrementing = false; // ដោយសារ PK ជា VARCHAR
    protected $keyType = 'string';
    protected $fillable = ['room_id', 'room_name', 'capacity', 'type'];

    public function exams() {
        return $this->hasMany(Exam::class, 'room_id', 'room_id');
    }
}
