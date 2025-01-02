<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvironmentVariable extends Model
{
    protected $fillable = ['name', 'value', 'note'];
}
