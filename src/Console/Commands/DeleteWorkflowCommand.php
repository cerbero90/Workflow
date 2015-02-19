<?php namespace Cerbero\Workflow\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class DeleteWorkflowCommand extends WorkflowGeneratorCommand {

	use DeleteIfForcedTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow:delete';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete an existing workflow';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->inflector->of($name = $this->getWorkflowName());

		if( ! $this->pipelines->exists($name))
		{
			return $this->error("The workflow [$name] does not exist.");
		}

		$this->deleteAllFilesOfWorkflowIfForced($name);

		$this->pipelines->destroy($name);

		$this->info('Workflow deleted successfully.');
	}

	/**
	 * Delete all the generated files of the given workflow if forced.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @return	void
	 */
	protected function deleteAllFilesOfWorkflowIfForced($workflow)
	{
		$files = $this->pipelines->getPipesByPipeline($workflow);

		$files[] = $this->inflector->getCommand();

		$files[] = $this->inflector->getRequest();

		$this->deleteIfForced($files);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['force', '-f', InputOption::VALUE_NONE, 'Delete all the generated files of a workflow.'],
		];
	}

}