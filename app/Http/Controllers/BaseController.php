<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;


class BaseController extends Controller {
    // Share data for the header
    public function __construct(){
        View::share('headerLinks', [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'About', 'url' => url('/about')],
            ['name' => 'Contact', 'url' => url('/contact')],
        ]);
    }

    
}
