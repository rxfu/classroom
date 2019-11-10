<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Using extends Model
{
    public $table = 'js_jssy';

    public function classroom() {
        return $this->belongsTo('App\Classroom', 'jsh', 'jsh');
    }
}
