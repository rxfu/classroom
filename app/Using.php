<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Using extends Model
{
    use PresentableTrait;
    
    public $table = 'js_jssy';

    protected $presenter = 'App\Presenters\UsingPresenter';

    public function classroom() {
        return $this->belongsTo('App\Classroom', 'jsh', 'jsh');
    }
}
