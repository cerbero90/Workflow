<?php namespace Cerbero\Workflow\Console\Commands;

use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Symfony\Component\Console\Input\InputArgument;
use Cerbero\Workflow\Console\Drawing\Drawer;
use Illuminate\Console\Command;

class ReadWorkflowCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow:read';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show an existing workflow';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Repositories\PipelineRepositoryInterface	$pipelines	Pipeline repository.
	 */
	protected $pipelines;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Console\Drawing\Drawer	$drawer	The workflow drawer.
	 */
	protected $drawer;

	/**
	 * Set the dependencies.
	 *
	 * @param  \Cerbero\Workflow\Repositories\PipelineRepositoryInterface  $pipelines
	 * @param  \Cerbero\Workflow\Console\Drawing\Drawer  $drawer
	 * @return void
	 */
	public function __construct(PipelineRepositoryInterface $pipelines, Drawer $drawer)
	{
		parent::__construct();

		$this->pipelines = $pipelines;

		$this->drawer = $drawer;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$workflow = ucfirst($this->argument('name'));

		if( ! $this->pipelines->exists($workflow))
		{
			return $this->error("The workflow [$workflow] does not exist.");
		}

		$this->info($this->drawer->draw($workflow));
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
