<?php namespace Cerbero\Workflow\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class UpdateWorkflowCommand extends WorkflowGeneratorCommand {

	use AttachesPipesTrait, DeleteIfForcedTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update an existing workflow';

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
		$name = $this->getWorkflowName();

		if( ! $this->pipelines->exists($name))
		{
			return $this->error("The workflow [$name] does not exist.");
		}

		$this->generatePipes();

		$this->deleteDetachedIfForced();

		$this->updateWorkflow($name);

		$this->info('Workflow updated successfully.');
	}

	/**
	 * Delete the detached pipes if force is set.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function deleteDetachedIfForced()
	{
		$detachments = $this->getNamespacedPipesByOption('detach');

		$this->deleteIfForced($detachments);
	}

	/**
	 * Update the given workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @return	void
	 */
	protected function updateWorkflow($workflow)
	{
		$attachments = $this->getNamespacedPipesByOption('attach');

		$detachments = $this->getNamespacedPipesByOption('detach');

		$this->pipelines->update($workflow, $attachments, $detachments);
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
			['detach', '-d', InputOption::VALUE_OPTIONAL, 'The pipes to detach from the workflow.', null],
			['force', '-f', InputOption::VALUE_NONE, 'Delete the files of detached pipes.'],
		];
	}

}
