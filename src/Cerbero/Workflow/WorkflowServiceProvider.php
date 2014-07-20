<?php namespace Cerbero\Workflow;

use Illuminate\Support\ServiceProvider;

class WorkflowServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cerbero/workflow');

		$this->commands('cerbero.workflow.command');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerGenerator();

		$this->registerCommand();
	}

	/**
	 * Register the scaffolding generator.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function registerGenerator()
	{
		$this->app->bind('Cerbero\Workflow\Scaffolding\GeneratorInterface', 'Cerbero\Workflow\Scaffolding\Generator');
	}

	/**
	 * Register the Artisan command.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function registerCommand()
	{
		$this->app->bindShared('cerbero.workflow.command', function($app)
		{
			return $app->make('Cerbero\Workflow\WorkflowCommand');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cerbero.workflow.command');
	}

}
