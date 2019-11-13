<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UsingPresenter extends Presenter
{
    public function b2eWeek()
    {
        if ($this->ksz === $this->jsz) {
            return $this->ksz;
        } else {
            return $this->ksz . ' ~ ' . $this->jsz;
        }
    }

    public function b2eSection()
    {
        $sections = explode(',', $this->jc);

        return max($sections) === min($sections) ? max($sections) : min($sections) . ' ~ ' . max($sections);
    }
}
