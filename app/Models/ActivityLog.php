<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'log_id';
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'old_value', 'new_value', 'created_at'];
    
    // បកប្រែ JSON មកជា Array អូតូ
    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class, 'user_id', 'user_id'); }
}
