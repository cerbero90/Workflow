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
		$I = $this->getModule('Filesystem');

		$I->amInPath(base_path());
	}

	/**
	 * Run an artisan command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$command
	 * @return	void
	 */
	public function runArtisan($command)
	{
		$this->amInRoot();

		$I = $this->getModule('Cli');

		$I->runShellCommand("php artisan {$command}");
	}

}