<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psy\Exception\TypeErrorException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JSONWebToken
{
    /**
     * @param  array<string>  $credentials
     * @return array<int,string>
     */
    public function authorize(array $credentials): array
    {
        try {
            $token = JWTAuth::attempt($credentials);

            return $token
                ? [Response::HTTP_OK, $token]
                : [Response::HTTP_NOT_FOUND, __('auth.failed')];
        } catch (JWTException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (TypeErrorException $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }

    /**
     * @param  string  $token
     * @return array<int,User|string>
     */
    public function getUserWithToken(string $token): array
    {
        try {
            $user = JWTAuth::setToken($token)->toUser();

            return $user
                ? [Response::HTTP_OK, ['user' => $user]]
                : [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'User'])];
        } catch (JWTException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return [Response::HTTP_NOT_FOUND, $e->getMessage()];
        } catch (TypeErrorException $e) {
            return [Response::HTTP_BAD_REQUEST, $e->getMessage()];
        }
    }

    /**
     * @param  string  $token
     * @return array<int,bool>
     */
    public function invalidate(string $token): array
    {
        try {
            return JWTAuth::invalidate($token)
                ? [Response::HTTP_OK, __('auth.logged_out')]
                : [Response::HTTP_NOT_FOUND, __('app.404', ['attribute' => 'User'])];
        } catch (JWTException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (TypeErrorException $e) {
            return [Response::HTTP_BAD_REQUEST, $e->getMessage()];
        }
    }

    /**
     * @param  string  $token
     * @return array<int,bool>
     */
    public function refresh(string $token): array
    {
        try {
            $token = JWTAuth::setToken($token)->refresh();

            return $token
                ? [Response::HTTP_OK, $token]
                : [Response::HTTP_NOT_FOUND, __('services.jwt.token.refresh_fail')];
        } catch (JWTException $e) {
            return [$e->getCode(), $e->getMessage()];
        } catch (TypeErrorException $e) {
            return [Response::HTTP_BAD_REQUEST, $e->getMessage()];
        }
    }

    /**
     * @return User|null
     *
     * @throws JWTException
     */
    public static function getUser(): User|null
    {
        try {
            return JWTAuth::user();
        } catch (JWTException $e) {
            return [$e->getCode(), $e->getMessage()];
        }
    }
}
