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

		$I->runShellCommand("php artisan {$command} --no-interaction");
	}

	/**
	 * Move to the workflows path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function amInWorkflows()
	{
		$I = $this->getModule('Filesystem');

		$I->amInPath(app_path('workflows'));
	}

	/**
	 * Check if the workflow is bound.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @return	void
	 */
	public function seeWorkflowBound($workflow)
	{
		$I = $this->getModule('Filesystem');

		$I->openFile('bindings.php');

		$I->seeInThisFile('<?php');

		$I->seeInThisFile("// Bind the [{$workflow}] workflow");

		$I->seeInThisFile("App::bind('Workflows\\{$workflow}\\{$workflow}Interface', function(\$app)");

		$I->seeInThisFile("return new Workflows\\{$workflow}\\{$workflow};");
	}

}