<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $casts = ['extra_inputs' => 'array'];
    use HasFactory;

    public function checkField($id)
    {
        if ($this->extra_inputs) {
            foreach (json_decode($this->extra_inputs,true) as $key => $value) {
                if ($value['id'] == $id) {
                    return $value['value'];
                }
            }
        }

        return false;
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partner');
    }
}
