<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class TempPresenter extends Presenter
{
    public function b2eWeek()
    {
        if ($this->kszc === $this->jszc) {
            return $this->kszc;
        } else {
            return $this->kszc . ' ~ ' . $this->jszc;
        }
    }

    public function b2eSection()
    {
        if ($this->ksjs === $this->jsjs) {
            return $this->ksjs;
        } else {
            return $this->ksjs . ' ~ ' . $this->jsjs;
        }
    }
}
