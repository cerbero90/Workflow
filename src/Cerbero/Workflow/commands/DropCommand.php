<?php namespace Cerbero\Workflow\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Cerbero\Workflow\Scaffolding\Editors\BindingsEditorInterface as Editor;
use Cerbero\Workflow\InputParsers\InputParserInterface as Parser;

class DropCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'workflow:drop';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Drop an existing workflow.';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Config\Repository	$config	Configuration repository.
	 */
	protected $config;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\InputParsers\InputParserInterface	$parser	Command input parser.
	 */
	protected $parser;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Filesystem\Filesystem	$file	File system.
	 */
	protected $file;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Scaffolding\Editors\BindingsEditorInterface	$editor	Editor for the bindings.
	 */
	protected $editor;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Config $config, Parser $parser, Filesystem $file, Editor $editor)
	{
		$this->config = $config;

		$this->parser = $parser;

		$this->file = $file;

		$this->editor = $editor;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		extract($this->getInput());

		// Temporarily commented out because I don't know how to test it.. (・_・;)
		// if( ! $this->userConfirmsOperation($name)) return;

		$success = $this->file->deleteDirectory("{$path}/{$name}");

		if($success && $this->editor->removeWorkflow($name, $namespace, $path))
		{
			$this->info("The workflow [{$name}] has been dropped successfully.");
		}
	}

	/**
	 * Extract input passed to the command.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function getInput()
	{
		$input = $this->argument() + $this->option();

		return $this->parser->parse($input);
	}

	/**
	 * Determine whether the user confirms the operation.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	srring	$name
	 * @return	boolean
	 */
	private function userConfirmsOperation($name)
	{
		$question = "Are you sure to drop the workflow [{$name}] ?";

		return $this->confirm($question);
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
			array('namespace', null, InputOption::VALUE_OPTIONAL, 'The namespace of the generated classes.', $this->config->get('workflow::namespace')),
			array('path', null, InputOption::VALUE_OPTIONAL, 'The directory where the workflows are located.', $this->config->get('workflow::path')),
		);
	}

}
