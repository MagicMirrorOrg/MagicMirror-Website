<?php

namespace MagicMirror\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use Socialite;
use MagicMirror\User;

class AuthController extends Controller
{

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    /**
     * Logout the currently logged in user.
     *
     * @return Response
     */
    public function logout() {
        Auth::logout();

        return Redirect::to('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {

            $authUser->github_token = $githubUser->token;
            $authUser->save();
            
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'github_token' => $githubUser->token,
            'api_token' => str_random(60),
            'avatar' => $githubUser->avatar
        ]);
    }
}