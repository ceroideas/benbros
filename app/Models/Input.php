<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    public function options()
    {
        return $this->hasMany('App\Models\InputOption');
    }

    public function sameAsActivity()
    {
        $a = Activity::where('name',$this->title)->first();

        return $a;
    }

    public function getTitleAttribute($value)
    {
        if (\App::getLocale() == 'es') {
            return $value;
        }

        $t = $this->getTranslation('title',\App::getLocale());
        /*Translate::where('table','inputs')
        ->where('ref_id',$this->id)
        ->where('column','title')
        ->where('lang',\App::getLocale())
        ->first();*/

        if (!$t) {
            return $value;
        }

        return $t->value;
    }

    public function getTranslation($column,$lang,$return_value = false)
    {
        $t = Translate::where('table','inputs')
        ->where('ref_id',$this->id)
        ->where('column',$column)
        ->where('lang',$lang)
        ->first();

        if ($t) {
            if ($return_value) {
                return $t->value;
            }
            return $t;
        }

    }
}
