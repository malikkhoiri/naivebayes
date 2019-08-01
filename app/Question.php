<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['filename', 'size', 'type', 'path', 'mapel_id', 'class_id'];
}
