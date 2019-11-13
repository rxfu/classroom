<?php

namespace App;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use Compoships;
    
    public $table = 'js_jsxx';

    public function campus()
    {
        return $this->belongsTo('App\Campus', 'xqh', 'dm');
    }

    public function building()
    {
        return $this->belongsTo('App\Building', ['xqh', 'jxl'], ['xqh', 'dm']);
    }
}
