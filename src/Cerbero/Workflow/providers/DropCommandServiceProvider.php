<?php namespace Cerbero\Workflow\Providers;

use Illuminate\Support\ServiceProvider;
use Cerbero\Workflow\InputParsers\DropCommandParser;
use Cerbero\Workflow\Commands\DropCommand;

class DropCommandServiceProvider extends ServiceProvider {

	/**
	 * Register the command to drop an existing workflow.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBindingsEditor();

		$this->app->bindShared('cerbero.workflow.commands.drop', function($app)
		{
			return new DropCommand
			(
				$app['config'], new DropCommandParser, $app['files'],

				$app->make('Cerbero\Workflow\Scaffolding\Editors\BindingsEditor')
			);
		});
	}

	/**
	 * Register the bindings editor.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerBindingsEditor()
	{
		$this->app->bind('Cerbero\Workflow\Scaffolding\Editors\BindingsEditorInterface', function($app)
		{
			return $app->make('Cerbero\Workflow\Scaffolding\Editors\BindingsEditor');
		});
	}

}
