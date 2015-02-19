<?php namespace Cerbero\Workflow\Wrappers;

/**
 * Interface for namespace detectors.
 *
 * @author	Andrea Marco Sartori
 */
interface NamespaceDetectorInterface {

	/**
	 * Detect the namespace used by an application.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function detect();

}