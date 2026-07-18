<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    protected $fillable = ['sender_user_id', 'recipient_type', 'recipient_id', 'title', 'body', 'sent_at', 'read_at'];

    public function sender() { return $this->belongsTo(User::class, 'sender_user_id', 'user_id'); }
}
