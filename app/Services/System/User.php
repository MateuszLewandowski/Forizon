<?php

namespace App\Services\System;

use App\Models\User as UserModel;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Call an user instance stored in AuthClosure middleware.
     *
     * @return UserModel
     *
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     */
    final public static function callUser(): UserModel
    {
        try {
            if (! $user = App::make(UserModel::class)) {
                return Auth::user();
            }

            return $user;
        } catch (ModelNotFoundException $e) {
        } catch (AuthorizationException $e) {
        }
    }
}
