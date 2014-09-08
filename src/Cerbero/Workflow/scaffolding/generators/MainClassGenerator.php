<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Main class generator.
 *
 * @author	Andrea Marco Sartori
 */
class MainClassGenerator extends AbstractGenerator
{

	/**
	 * Retrieve the template name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getTemplate()
	{
		return 'main';
	}

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getFilename()
	{
		$name = $this->data['name'];

		return "{$name}/{$name}.php";
	}

}