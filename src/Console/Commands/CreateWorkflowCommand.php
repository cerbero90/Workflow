<?php namespace Cerbero\Workflow\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class CreateWorkflowCommand extends WorkflowGeneratorCommand {

	use AttachesPipesTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new workflow';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$type	Type of class to generate.
	 */
	protected $type = 'Pipe';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->inflector->of($name = $this->getWorkflowName());

		if($this->pipelines->exists($name))
		{
			return $this->error("The workflow [$name] already exists.");
		}

		$this->generateAllNeededFiles();

		$this->pipelines->store($name, $this->getNamespacedPipesByOption('attach'));

		$this->info('Workflow created successfully.');
	}

	/**
	 * Generate all the needed files.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function generateAllNeededFiles()
	{
		$this->settleRepositoryIfNotExists();

		$this->generateCommand();

		$this->generateRequestIfGuarded();

		$this->generatePipes();
	}

	/**
	 * Settle the pipeline repository if it does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function settleRepositoryIfNotExists()
	{
		$source = $this->pipelines->getSource();

		if( ! $this->files->exists($source))
		{
			$this->pipelines->settle();
		}
	}

	/**
	 * Create the command to handle.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function generateCommand()
	{
		$name = $this->inflector->getCommand();

		$this->call('make:command', compact('name'));
	}

	/**
	 * Create the request if unguard is not set.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function generateRequestIfGuarded()
	{
		if( ! $this->option('unguard'))
		{
			$name = $this->inflector->getRequest();

			$this->call('make:request', compact('name'));
		}
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['attach', '-a', InputOption::VALUE_OPTIONAL, 'The pipes to attach to the workflow.', null],
			['unguard', '-u', InputOption::VALUE_NONE, 'Do not make this workflow validate data.', null],
		];
	}

}
