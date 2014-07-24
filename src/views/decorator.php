<?php namespace $namespace$\Decorators;

use $namespace$\$name$Interface;

/**
 * Decorator of the $lowername$ workflow.
 *
 */
class $decorator$ implements $name$Interface
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
	public function $method$($data)
	{
		$this->$lowername$->$method$($data);
	}

}