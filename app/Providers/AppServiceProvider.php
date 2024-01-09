<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('exists_with_role', function ($attribute, $value, $parameters, $validator) {
            return DB::table($parameters[0])
                ->where($parameters[1], $attribute, $value)
                ->where('role', $parameters[2])
                ->exists();
        });
    }
}
