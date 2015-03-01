<?php
/**
 * Created by PhpStorm.
 * User: tabutcu
 * Date: 2/28/15
 * Time: 3:03 PM
 */

namespace App\Repositories;
use App\User;


class UserRepository {


    public function findByUsernameOrCreate($userData)
    {

        return User::firstOrCreate([
            'name'  =>  $userData->nickname,
            'email' =>  $userData->email,

        ]);

    }
}