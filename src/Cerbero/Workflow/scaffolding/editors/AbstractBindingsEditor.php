<?php namespace Cerbero\Workflow\Scaffolding\Editors;

use Illuminate\Filesystem\Filesystem;

/**
 * Abstract implementation of a bindings editor.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractBindingsEditor implements BindingsEditorInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Filesystem\Filesystem	$file	File system.
	 */
	protected $file;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Filesystem\Filesystem	$file
	 * @return	void
	 */
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}

	/**
	 * Remove a bound workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	string	$namespace
	 * @param	string	$path
	 * @return	boolean
	 */
	public function removeWorkflow($name, $namespace, $path)
	{
		$content = $this->file->get("{$path}/" . $this->getFilename());

		$bindings = preg_replace($this->getPattern($name, $namespace), '', $content);

		return $this->file->put("{$path}/bindings.php", $bindings) !== false;
	}

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	abstract protected function getFilename();

	/**
	 * Retrieve the regular expression pattern to apply.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	string	$namespace
	 * @return	string
	 */
	abstract protected function getPattern($name, $namespace);

}