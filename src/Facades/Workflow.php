<?php namespace Cerbero\Workflow\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * @see \Cerbero\Workflow\Workflow
 */
class Workflow extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'cerbero.workflow'; }

}
