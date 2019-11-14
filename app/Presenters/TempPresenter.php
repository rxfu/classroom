<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class TempPresenter extends Presenter
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
        if ($this->ksj === $this->jsj) {
            return $this->ksj;
        } else {
            return $this->ksj . ' ~ ' . $this->jsj;
        }
    }
}
