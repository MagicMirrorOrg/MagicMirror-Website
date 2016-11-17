<?php

namespace MagicMirror\Http\Controllers\Api;

use Illuminate\Http\Request;
use MagicMirror\Http\Controllers\Api\ApiController;
use Auth;

class MeController extends ApiController
{
    /** 
    * Returns the object of the current user.
    *
    * @return array
    */
    public function me() {
        return Auth::user();
    }

    /** 
    * Returns all the repositories by the current userr.
    *
    * @return array
    */
    public function repositories() {
        return Auth::user()->repositories();
    }
}
