<?php namespace Cerbero\Workflow;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Cerbero\Workflow\Scaffolding\GeneratorInterface as Scaffolding;

class WorkflowCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Speed up the workflow to add new features.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Scaffolding $scaffolding)
	{
		parent::__construct();

		$this->scaffolding = $scaffolding;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
	}

	/**
	 * Retrieve the workflow data.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	protected function getWorkflow()
	{
		$data = $this->argument() + $this->option();

		return new WorkflowDataTransfer($data);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'The name of the workflow.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('folder', '-f', InputOption::VALUE_OPTIONAL, 'The folder to place files in.', null),
			array('namespace', '-n', InputOption::VALUE_OPTIONAL, 'The workflow namespace.', null),
		);
	}

}
