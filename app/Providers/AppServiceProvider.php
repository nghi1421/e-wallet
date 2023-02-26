<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\LinkedRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\LinkedRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Models\User;
use App\Models\Linked;
use App\Models\Bank;
use App\Models\Payment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, function () {
            return new UserRepository(new User());
        });

        $this->app->singleton(LinkedRepositoryInterface::class, function () {
            return new LinkedRepository(new Linked(), new Bank(), new User());
        });

        $this->app->singleton(PaymentRepositoryInterface::class, function () {
            return new PaymentRepository(new Payment(), new Linked(), new Bank(), new User());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
