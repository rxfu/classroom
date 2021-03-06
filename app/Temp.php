<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Temp extends Model
{
    use PresentableTrait;

    public $table = 'js_sq';

    protected $presenter = 'App\Presenters\TempPresenter';

    public function classroom()
    {
        return $this->belongsTo('App\Classroom', 'jsh', 'jsh');
    }
}
