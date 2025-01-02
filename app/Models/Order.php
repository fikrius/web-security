<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'status', 'code', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID and code
        static::creating(function ($order) {
            $order->uuid = (string) Str::uuid();

            // Generate a random 5-digit unique number
            $randomNumber = mt_rand(10000, 99999);

            // Ensure uniqueness of the random number
            while (Order::where('code', 'LIKE', 'INV/' . $randomNumber . '/%')->exists()) {
                $randomNumber = mt_rand(10000, 99999);
            }

            // Generate the code
            $order->code = 'INV/' . $randomNumber . '/' . date('d') . '/' . date('m') . '/' . date('Y');
        });
    }
}
