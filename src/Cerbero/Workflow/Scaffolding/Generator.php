<?php namespace Cerbero\Workflow\Scaffolding;

use \Illuminate\Filesystem\Filesystem;
use Cerbero\Workflow\Scaffolding\CompilerInterface as Compiler;
use Cerbero\Workflow\WorkflowDataTransfer as Workflow;
use Cerbero\Workflow\FileCreationException;

/**
 * Scaffolding generator.
 *
 * @author	Andrea Marco Sartori
 */
class Generator implements GeneratorInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Filesystem\Filesystem	$file	Laravel filesystem.
	 */
	protected $file;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Scaffolding\CompilerInterface	$compiler	Template files compiler.
	 */
	protected $compiler;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\WorkflowDataTransfer	$workflow	Workflow data transfer.
	 */
	protected $workflow;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$directory	The main directory.
	 */
	protected $directory;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Filesystem\Filesystem	$file
	 * @param	Cerbero\Workflow\Scaffolding\CompilerInterface	$compiler
	 * @return	void
	 */
	public function __construct(Filesystem $file, Compiler $compiler)
	{
		$this->file = $file;

		$this->compiler = $compiler;
	}

	/**
	 * Generate the scaffolding.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @return	boolean
	 */
	public function generate(Workflow $workflow)
	{
		$this->workflow = $workflow;

		$this->createMainDirectory();

		$this->createWorkflow();

		$this->appendBindings();
	}

	/**
	 * Create the workflow structure.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function createWorkflow()
	{
		$name = $this->workflow->name;

		$this->createDirectory("{$name}");

		$this->createFileFromTemplate('interface', "{$name}/{$name}Interface.php");

		$this->createFileFromTemplate('class', "{$name}/{$name}.php");

		$this->createDecorators($this->workflow->decorators);
	}

	/**
	 * Create the directory to put workflows in.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function createMainDirectory()
	{
		$this->directory = app_path($this->workflow->folder);

		if( ! $this->file->isDirectory($this->directory))
		{
			$this->createDirectory();

			$this->createFileFromTemplate('empty', "bindings.php");
		}
	}

	/**
	 * Create a directory.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|null	$directory
	 * @return	void
	 */
	protected function createDirectory($directory = null)
	{
		$path = "{$this->directory}/{$directory}";

		$success = $this->file->makeDirectory($path);

		if( ! $success) throw new FileCreationException($path);
	}

	/**
	 * Create a file from a template.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @param	string	$file
	 * @return	void
	 */
	protected function createFileFromTemplate($template, $file)
	{
		$path = "{$this->directory}/{$file}";

		$content = $this->compiler->compile($template, $this->workflow);

		$success = $this->file->put($path, $content);

		if( ! $success) throw new FileCreationException($path);
	}

	/**
	 * Create the decorators.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$decorators
	 * @return	void
	 */
	protected function createDecorators(array $decorators = array())
	{
		$folder = "{$this->workflow->name}/decorators";

		$this->createDirectory($folder);

		foreach ($decorators as $decorator)
		{
			$this->workflow->decorator = $decorator;

			$this->createDecoratorByName($decorator, $folder);
		}
	}

	/**
	 * Create a decorator depending on its name.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	string	$folder
	 * @return	void
	 */
	protected function createDecoratorByName($name, $folder)
	{
		$path = "{$folder}/{$name}.php";

		$template = str_contains(strtolower($name), 'validat') ? 'validator' : 'decorator';

		$this->createFileFromTemplate($template, $path);
	}

	/**
	 * Append the bindings to register.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	protected function appendBindings()
	{
		$content = $this->compiler->compile('binding', $this->workflow);

		$success = $this->file->append("{$this->directory}/bindings.php", $content);

		if( ! $success) throw new \Exception('Unable to register the bindings');
	}

}