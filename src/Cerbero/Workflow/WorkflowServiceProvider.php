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
	 * @author	Andrea Marco Sartori
	 * @var		array	$commands	List of commands to register.
	 */
	protected $commands = array('create', 'drop');

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cerbero/workflow');

		$this->commands($this->provides());

		$this->validation();
	}

	/**
	 * Handle validation errors.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function validation()
	{
		$this->app->error
		(
			$this->app['config']['workflow::validation_failure']
		);
	}

	/**
	 * Register all commands.
	 *
	 * @return void
	 */
	public function register()
	{
		foreach ($this->commands as $command)
		{
			$name = ucfirst($command);

			$this->app->register("Cerbero\Workflow\Providers\\{$name}CommandServiceProvider");
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array_map(function($command)
		{
			return "cerbero.workflow.commands.{$command}";

		}, $this->commands);
	}

}
