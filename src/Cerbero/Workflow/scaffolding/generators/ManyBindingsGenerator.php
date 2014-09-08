<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Bindings file generator which can nest unlimited decorators.
 *
 * @author	Andrea Marco Sartori
 */
class ManyBindingsGenerator extends BindingsGenerator
{

	const NESTING_PER_DECORATOR = 8;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		int	$oldLimit	Initial maximum number of function nesting.
	 */
	private $oldLimit;

	/**
	 * Generate the scaffolding files.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function generate(array $data)
	{
		$this->increaseFunctionNesting($data['decorators']);

		$success = parent::generate($data);

		$this->resetFunctionNesting();

		return $success;
	}

	/**
	 * Increase the maximum number of function nesting depending on the number of decorators.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$decorators
	 * @return	void
	 */
	private function increaseFunctionNesting($decorators)
	{
		$limit = count($decorators) * self::NESTING_PER_DECORATOR;

		if($limit > ini_get('xdebug.max_nesting_level'))
		{
			$this->oldLimit = ini_set('xdebug.max_nesting_level', $limit);
		}
	}

	/**
	 * Reset the maximum number of function nesting.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function resetFunctionNesting()
	{
		if($limit = $this->oldLimit)
		{
			ini_set('xdebug.max_nesting_level', $limit);
		}
	}

}