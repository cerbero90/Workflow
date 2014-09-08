<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Interface for scaffolding generators.
 *
 * @author	Andrea Marco Sartori
 */
interface GeneratorInterface
{

	/**
	 * Generate the scaffolding files.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function generate(array $data);

}