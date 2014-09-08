<?php namespace Cerbero\Workflow\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Config\Repository as Config;
use Cerbero\Workflow\InputParsers\InputParserInterface as Parser;
use Cerbero\Workflow\Scaffolding\Builders\BuilderInterface as Scaffolding;

class CreateCommand extends Command {

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
	protected $description = 'Create a new workflow.';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Support\Facades\Config	$config	Configuration repository.
	 */
	protected $config;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Commands\Parsers\ParserInterface	$parser	Command input parser.
	 */
	protected $parser;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Scaffolding\Builders\BuilderInterface	$scaffolding	Scaffolding builder.
	 */
	protected $scaffolding;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Config $config, Parser $parser, Scaffolding $scaffolding)
	{
		$this->config = $config;

		$this->parser = $parser;

		$this->scaffolding = $scaffolding;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$input = $this->argument() + $this->option();

		$workflow = $this->parser->parse($input);

		if($this->scaffolding->build($workflow))
		{
			$this->info("The workflow [{$workflow['name']}] has been created successfully.");
		}
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
			array('decorators', '-d', InputOption::VALUE_OPTIONAL, 'The list of decorators.', null),
			array('method', null, InputOption::VALUE_OPTIONAL, 'The method name to run the workflow.', $this->config->get('workflow::method')),
			array('path', null, InputOption::VALUE_OPTIONAL, 'The directory to put files in.', $this->config->get('workflow::path')),
			array('namespace', null, InputOption::VALUE_OPTIONAL, 'The namespace of the generated classes.', $this->config->get('workflow::namespace')),
			array('author', null, InputOption::VALUE_OPTIONAL, 'Your name in PHP comments.', $this->config->get('workflow::author')),
		);
	}

}
