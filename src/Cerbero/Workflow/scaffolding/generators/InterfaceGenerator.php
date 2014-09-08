<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Interface generator.
 *
 * @author	Andrea Marco Sartori
 */
class InterfaceGenerator extends AbstractGenerator
{

	/**
	 * Retrieve the template name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getTemplate()
	{
		return 'interface';
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

		return "{$name}/{$name}Interface.php";
	}

}