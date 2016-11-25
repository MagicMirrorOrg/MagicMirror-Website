<?php

namespace MagicMirror\Http\Controllers\Api;

use Illuminate\Http\Request;
use MagicMirror\Http\Controllers\Controller;
use GrahamCampbell\GitHub\Facades\GitHub;

class GitHubController extends Controller
{
    public function fetch($user, $repository) {
        return GitHub::connection('application')->repo()->show($user, $repository);
    }
}
