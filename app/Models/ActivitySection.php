<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitySection extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
