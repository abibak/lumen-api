<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use \App\Http\Traits\User as UserTrait;

class AuthServiceProvider extends ServiceProvider
{
    use UserTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $request_token = $request->header('Authorization');

            if ($request_token) {
                try {
                    $data = $this->decode_token($request_token);
                    return User::find($data->sub);
                } catch (\Exception $e) {
                    //
                }
            }
        });
    }
}
