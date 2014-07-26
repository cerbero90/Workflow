<?php namespace Cerbero\Workflow\Validation;

/**
 * Validator interface.
 *
 * @author	Andrea Marco Sartori
 */
interface ValidatorInterface
{

	/**
	 * Validate the input.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	void
	 */
	public function validate(array $data = array());

}