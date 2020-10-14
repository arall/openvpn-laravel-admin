<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    /**
     * Login
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $this->validateUser($googleUser);

        $user = $this->getUser($googleUser);
        auth()->login($user, true);

        return redirect()->intended('/');
    }

    /**
     * Validates the callback request.
     *
     * @param  mixed $user
     */
    private function validateUser($user)
    {
        if (!$user || !isset($user->user['hd']) || !isset($user->user['email'])) {
            abort(403);
        }

        if ($user->user['hd'] != env('AUTH_DOMAIN')) {
            abort(403, 'Only ' . env('AUTH_DOMAIN') . ' domain is allowed!');
        }
    }

    /**
     * Find (or create) a user.
     *
     * @param  object $googleUser
     * @return User
     */
    private function getUser(object $googleUser)
    {
        $model = User::firstOrNew(['email' => $googleUser->getEmail()]);
        $model->google_id = $googleUser->getId();
        $model->name = $googleUser->getName();
        $model->save();

        return $model;
    }
}