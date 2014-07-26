<?php namespace Cerbero\Workflow\Validation;

use Illuminate\Support\MessageBag;

/**
 * Exception thrown after validation failure.
 *
 * @author	Andrea Marco Sartori
 */
class Exception extends \Exception
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Support\MessageBag	$errors	Validation errors.
	 */
	public $errors;

	/**
	 * Set the validation errors.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Support\MessageBag	$errors
	 * @return	void
	 */
	public function __construct(MessageBag $errors)
	{
		$this->errors = $errors;

		parent::__construct('Input validation failure.');
	}

}