<?php

namespace App\Http\Controllers;

class PageController
{
    public function goToUrl($url)
    {
        return view('goTo',['url'=>$url]);
    }
}
