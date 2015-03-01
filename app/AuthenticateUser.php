<?php namespace App;

use Illuminate\Contracts\Auth\Guard;
use App\Repositories\UserRepository;
use Laravel\Socialite\Contracts\Factory as Socialite;
class AuthenticateUser {
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Guard
     */
    private $auth;
    /**
     * @param UserRepository $users
     * @param Socialite $socialite
     * @param Guard $auth
     */
    public function __construct(UserRepository $users, Socialite $socialite, Guard $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }
    /**
     * @param boolean $hasCode
     * @param AuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($hasCode, AuthenticateUserListener $listener)
    {
        if ( ! $hasCode) return $this->getAuthorizationFirst();
        $user = $this->users->findByUsernameOrCreate($this->getGithubUser());
        $this->auth->login($user, true);
        return $listener->userHasLoggedIn($user);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst()
    {
        return $this->socialite->driver('github')->redirect();
    }
    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getGithubUser()
    {
        return $this->socialite->driver('github')->user();
    }
}