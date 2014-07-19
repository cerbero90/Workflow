<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

	/**
	 * Move to the project root.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function amInRoot()
	{
		$root = base_path();

		$I = $this->getModule('Filesystem');

		$I->amInPath($root);
	}

}