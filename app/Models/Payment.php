<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'invoice_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['invoice_id', 'student_id', 'description', 'total_fee', 'discount', 'amount_paid', 'payment_date'];

    public function student() { return $this->belongsTo(Student::class, 'student_id', 'student_id'); }
}
