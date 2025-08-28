<?php

namespace App\Composers;

//use Illuminate\Support\Facades\View;

use Illuminate\View\View;

class TestComposer
{
    public function compose(View $view)
    {
        $view->with('count', 1000);
    }

}
