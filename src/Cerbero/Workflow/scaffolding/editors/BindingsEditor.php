<?php namespace Cerbero\Workflow\Scaffolding\Editors;

use Illuminate\Filesystem\Filesystem;

/**
 * Editor of the bindings.php file.
 *
 * @author	Andrea Marco Sartori
 */
class BindingsEditor extends AbstractBindingsEditor
{

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getFilename()
	{
		return 'bindings.php';
	}

	/**
	 * Retrieve the regular expression pattern to apply.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	string	$namespace
	 * @return	string
	 */
	protected function getPattern($name, $namespace)
	{
		return "/((?:\/\/ Bind the \[{$name}[\s\S]+)?.+{$namespace}\\\\{$name}\\\\{$name}Interface[\s\S]+?\n\n)/";
	}

}