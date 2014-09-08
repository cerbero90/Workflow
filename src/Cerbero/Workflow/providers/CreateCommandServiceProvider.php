<?php namespace Cerbero\Workflow\Providers;

use Illuminate\Support\ServiceProvider;
use Cerbero\Workflow\InputParsers\CreateCommandParser;
use Cerbero\Workflow\Scaffolding\Builders\ScaffoldingBuilder;
use Cerbero\Workflow\Scaffolding\TemplateEngines\Blade\BladeTemplateEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class CreateCommandServiceProvider extends ServiceProvider {

	/**
	 * Register the command to create a new workflow.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerParser();

		$this->registerBuilder();

		$this->app->bindShared('cerbero.workflow.commands.create', function($app)
		{
			return $app->make('Cerbero\Workflow\Commands\CreateCommand');
		});
	}

	/**
	 * Register the command input parser.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerParser()
	{
		$this->app->bind('Cerbero\Workflow\InputParsers\InputParserInterface', function($app)
		{
			return new CreateCommandParser;
		});
	}

	/**
	 * Register the scaffolding builder.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerBuilder()
	{
		$this->registerGenerators();

		$this->app->bind('Cerbero\Workflow\Scaffolding\Builders\BuilderInterface', function($app)
		{
			return new ScaffoldingBuilder
			(
				$app->make('cerbero.workflow.scaffolding.generators')
			);
		});
	}

	/**
	 * Register the scaffolding generators.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerGenerators()
	{
		$this->registerTemplateEngine();

		$this->app->bind('cerbero.workflow.scaffolding.generators', function($app)
		{
			return array
			(
				$app->make('Cerbero\Workflow\Scaffolding\Generators\ManyBindingsGenerator'),
				$app->make('Cerbero\Workflow\Scaffolding\Generators\InterfaceGenerator'),
				$app->make('Cerbero\Workflow\Scaffolding\Generators\MainClassGenerator'),
				$app->make('Cerbero\Workflow\Scaffolding\Generators\DecoratorsGenerator'),
			);
		});
	}

	/**
	 * Register the template engine.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerTemplateEngine()
	{
		$this->registerBlade();

		$this->app->bind('Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface', function($app)
		{
			return $app->make('cerbero.workflow.scaffolding.templateEngines.blade');
		});
	}

	/**
	 * Register the template engine Blade.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerBlade()
	{
		$this->app->bind('cerbero.workflow.scaffolding.templateEngines.blade', function($app)
		{
			$paths = [ __DIR__ . '/../scaffolding/templateEngines/blade/templates' ];

			$finder = new FileViewFinder($app['files'], $paths);

			$factory = new Factory($app['view.engine.resolver'], $finder, $app['events']);

			return new BladeTemplateEngine($factory);
		});
	}

}
