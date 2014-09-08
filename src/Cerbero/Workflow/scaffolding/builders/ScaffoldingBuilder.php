<?php namespace Cerbero\Workflow\Scaffolding\Builders;

/**
 * Scaffolding builder.
 *
 * @author	Andrea Marco Sartori
 */
class ScaffoldingBuilder implements BuilderInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$generators	List of scaffolding files generators.
	 */
	protected $generators;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$generators
	 * @return	void
	 */
	public function __construct(array $generators)
	{
		$this->generators = $generators;
	}

	/**
	 * Build the workflow scaffolding.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function build(array $data)
	{
		$success = true;

		foreach ($this->generators as $generator)
		{
			$success = $success && $generator->generate($data);
		}
		return $success;
	}

}