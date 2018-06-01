<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ChandraCrudGeneratorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

        $this->commands(
        	'App\Console\Commands\ChandraCrudCommand',
			'App\Console\Commands\ChandraCrudControllerCommand',
			'App\Console\Commands\ChandraCrudModelCommand',
			'App\Console\Commands\ChandraCrudMigrationCommand',
			'App\Console\Commands\ChandraCrudViewCommand',
			'App\Console\Commands\ChandraCrudRouteCommand',
            'App\Console\Commands\ChandraCrudMenuCommand'
        );

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		//
	}	

}
