<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public $table = 'js_jsxx';

    public function campus() {
        return $this->belongsTo('App\Campus', 'xqh', 'xqh');
    }

    public function building() {
        return $this->belongsTo('App\Building', 'jxl', 'dm');
    }
}
