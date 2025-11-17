<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reffedByUser()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function customerUser()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
