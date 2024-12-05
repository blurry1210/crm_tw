<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'start_time', 'end_time', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
