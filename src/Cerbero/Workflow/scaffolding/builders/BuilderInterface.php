<?php namespace Cerbero\Workflow\Scaffolding\Builders;

/**
 * Interface for scaffolding builders.
 *
 * @author	Andrea Marco Sartori
 */
interface BuilderInterface
{

	/**
	 * Build the workflow scaffolding.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function build(array $data);

}