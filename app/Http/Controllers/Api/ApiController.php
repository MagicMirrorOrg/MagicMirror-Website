<?php

namespace MagicMirror\Http\Controllers\Api;

use Illuminate\Http\Request;
use MagicMirror\Http\Controllers\Controller;
use Auth;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
