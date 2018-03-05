<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Transformer\LeadTransformer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Resource::withoutWrapping();
        
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
}
