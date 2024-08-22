<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pit extends Model
{
    use HasFactory;

    public function days()
    {
        return $this->belongsToMany(Day::class);
    }
}
