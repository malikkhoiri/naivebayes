<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['class'];

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }
}
