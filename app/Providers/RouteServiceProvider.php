<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $ApiNamespace = 'App\Http\Controllers\API';
    protected $socialNameSpace = 'App\Http\Controllers\Social';
    protected $clientsNameSpace = 'App\Http\Controllers\Clients';
    protected $generalNameSpace = 'App\Http\Controllers\General';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //$this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapClientsRoutes();

        $this->mapGeneralRoutes();

        $this->mapSocialRoutes();


    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }



    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->ApiNamespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapSocialRoutes()
    {
        Route::prefix('social')
            ->middleware('api')
            ->namespace($this->socialNameSpace)
            ->group(base_path('routes/social.php'));
    }

    protected function mapGeneralRoutes()
    {
        Route::prefix('general')
            ->middleware('api')
            ->namespace($this->generalNameSpace)
            ->group(base_path('routes/general.php'));
    }

    protected function mapClientsRoutes()
    {
        Route::prefix('clients')
            ->namespace($this->clientsNameSpace)
            ->group(base_path('routes/clients.php'));
    }
}
