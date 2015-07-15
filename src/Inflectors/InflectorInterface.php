<?php namespace Cerbero\Workflow\Inflectors;

/**
 * Interface for inflectors.
 *
 * @author	Andrea Marco Sartori
 */
interface InflectorInterface {

	/**
	 * Set the word to inflect.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$word
	 * @return	$this
	 */
	public function of($word);

	/**
	 * Retrieve the inflected request.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getRequest();

	/**
	 * Retrieve the inflected job.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getJob();

}
