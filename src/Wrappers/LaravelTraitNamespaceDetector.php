<?php namespace Cerbero\Workflow\Wrappers;

use Illuminate\Console\AppNamespaceDetectorTrait;

/**
 * Detector that uses a Laravel trait to detect the namespace.
 *
 * @author	Andrea Marco Sartori
 */
class LaravelTraitNamespaceDetector implements NamespaceDetectorInterface {

	use AppNamespaceDetectorTrait;

	/**
	 * Detect the namespace used by an application.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function detect()
	{
		$namespace = $this->getAppNamespace();

		return rtrim($namespace, '\\');
	}

}