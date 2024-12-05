<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'start_time', 'end_time'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
