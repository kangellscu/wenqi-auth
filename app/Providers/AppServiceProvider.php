<?php

namespace App\Providers;

use Ramsey\Uuid\Uuid;
use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendValidator();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function extendValidator()
    {
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            $len = strlen($value);
            return $len >= 4 && $len <= 16;
        });

        Validator::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return empty($value) || Uuid::isValid($value);
        });
    }
}
