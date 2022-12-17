<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FailedController extends Controller
{
    protected $failed = 'auth.failed';

    public function failed()
    {   
        return view($this->failed);
    }
}
