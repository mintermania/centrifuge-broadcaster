<?php

namespace LaraComponents\Centrifuge;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastManager;

class CentrifugeServiceProvider extends ServiceProvider
{
	/**
	 * Add centrifuge broadcaster.
	 *
	 * @param \Illuminate\Broadcasting\BroadcastManager $broadcastManager
	 */
	public function boot(BroadcastManager $broadcastManager)
	{
		$broadcastManager->extend('centrifuge', function ($app) {
			return new CentrifugeBroadcaster($app->make('centrifuge'));
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('centrifuge', function ($app) {
			$config = $app->make('config')->get('broadcasting.connections.centrifuge');
			$http   = new Client();

			return new Centrifuge($config, $http);
		});

		$this->app->alias('centrifuge', 'LaraComponents\Centrifuge\Centrifuge');
		$this->app->alias('centrifuge', 'LaraComponents\Centrifuge\Contracts\Centrifuge');
	}
}
