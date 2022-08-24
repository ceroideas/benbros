<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function land()
    {
        return $this->belongsTo('App\Models\Land');
    }

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
}
