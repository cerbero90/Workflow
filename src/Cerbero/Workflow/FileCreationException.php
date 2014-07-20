<?php namespace Cerbero\Workflow;

/**
 * Display files creation exceptions.
 *
 * @author	Andrea Marco Sartori
 */
class FileCreationException extends \Exception
{

	/**
	 * Set the message to display.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @return	void
	 */
	public function __construct($path)
	{
		$message = "Unable to create [{$path}]";

		parent::__construct($message);
	}

}