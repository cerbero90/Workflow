<?php namespace Cerbero\Workflow\Validation;

use \Validator;

/**
 * Abstract validator.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractValidator implements ValidatorInterface
{

	/**
	 * Validate the input.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	void
	 */
	public function validate(array $data = array())
	{
		$validator = Validator::make($data, $this->getRules());

		if($validator->fails())
		{
			throw new Exception($validator->errors());
		}
	}

	/**
	 * Retrieve the rules to apply.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	abstract protected function getRules();

}