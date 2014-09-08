<?php namespace Cerbero\Workflow\Scaffolding\Editors;

/**
 * Interface for bindings editors.
 *
 * @author	Andrea Marco Sartori
 */
interface BindingsEditorInterface
{

	/**
	 * Remove a bound workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @param	string	$namespace
	 * @param	string	$path
	 * @return	boolean
	 */
	public function removeWorkflow($name, $namespace, $path);

}