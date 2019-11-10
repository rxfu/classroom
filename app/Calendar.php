<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public $table='jx_xl';

    protected $dates = [
        'rq',
    ];

    public function term() {
        return $this->belongsTo('App\Term', 'xq', 'dm');
    }
}
