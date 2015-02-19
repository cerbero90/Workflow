<?php namespace Cerbero\Workflow\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;

/**
 * Abstract implementation of a workflow generator.
 *
 * @author	Andrea Marco Sartori
 */
abstract class WorkflowGeneratorCommand extends GeneratorCommand {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Repositories\PipelineRepositoryInterface	$pipelines	Pipeline repository.
	 */
	protected $pipelines;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Inflectors\InflectorInterface	$inflector	Inflector.
	 */
	protected $inflector;

	/**
	 * Set the dependencies.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @return void
	 */
	public function __construct(
		Filesystem $files,
		PipelineRepositoryInterface $pipelines,
		InflectorInterface $inflector
	) {
		parent::__construct($files);

		$this->pipelines = $pipelines;

		$this->inflector = $inflector;
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../Stubs/pipe.stub';
	}

	/**
	 * Retrieve the name of the workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getWorkflowName()
	{
		$name = $this->argument('name');

		return ucfirst($name);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the workflow.'],
		];
	}

}