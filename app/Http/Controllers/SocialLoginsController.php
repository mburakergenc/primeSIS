<?php

namespace App\Http\Controllers;

use App\AuthenticateUser;
use App\AuthenticateUserListener;
use App\Http\Requests;
use Illuminate\Http\Request;

class SocialLoginsController extends Controller implements AuthenticateUserListener
{
    /**
     * @param AuthenticateUser $authenticateUser
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function socialLogin(AuthenticateUser $authenticateUser, Request $request)
    {
        $hasCode = $request->has('code');
        return $authenticateUser->execute($hasCode, $this);
    }
    /**
     * When a user has successfully been logged in...
     *
     * @param $user
     * @return \Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user)
    {
        return redirect('/');
    }


}
