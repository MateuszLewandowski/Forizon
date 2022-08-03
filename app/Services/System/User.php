<?php

namespace App\Services\System;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\User as UserModel;

class User
{
    /**
     * Call an user instance stored in AuthClosure middleware.
     *
     * @return UserModel
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     */
    public final static function callUser(): UserModel {
        try {
            if (!$user = App::make(UserModel::class)) {
                return Auth::user();
            }
            return $user;
        } catch (ModelNotFoundException $e) {

        } catch (AuthorizationException $e) {

        }
    }
}
