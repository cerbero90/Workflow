<?php namespace $namespace$\Decorators;

use $namespace$\$name$Interface;
use Cerbero\Workflow\Validation\AbstractValidator;

/**
 * Decorator of the $lowername$ workflow.
 *
 */
class $decorator$ extends AbstractValidator implements $name$Interface
{

	/**
	 * @var		$name$Interface	$$lowername$	$name$ implementation.
	 */
	protected $$lowername$;
	
	/**
	 * Set the dependencies.
	 *
	 * @param	$name$Interface	$$lowername$
	 * @return	void
	 */
	public function __construct($name$Interface $$lowername$)
	{
		$this->$lowername$ = $$lowername$;
	}

	/**
	 * Trigger the $lowername$ workflow.
	 *
	 * @param	$data
	 */
	public function $method$($data = null)
	{
		$this->validate($data);

		$this->$lowername$->$method$($data);
	}

	/**
	 * Retrieve the rules to apply.
	 *
	 * @return	array
	 */
	protected function getRules()
	{
		return [];
	}

}