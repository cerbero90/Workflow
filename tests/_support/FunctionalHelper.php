<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

	/**
	 * Retrieve the temporary folder.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|null	$path
	 * @return	string
	 */
	private function getTemp($path = null)
	{
		return __DIR__ . "/../tmp/{$path}";
	}

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

	/**
	 * Run a workflow command from artisan.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$command
	 * @return	void
	 */
	public function runCommand($command)
	{
		$command .= sprintf(' --path="%s"', $this->getTemp());

		$this->runArtisan($command);
	}

	/**
	 * Run a command avoiding interactive questions.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$command
	 * @return	void
	 */
	public function runNonInteractiveCommand($command)
	{
		$this->runCommand("-n $command");
	}

	/**
	 * Clean the temporary folder.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function cleanTemporaryFiles()
	{
		$I = $this->getModule('Filesystem');

		$I->cleanDir($this->getTemp());
	}

	/**
	 * Check two files have same content.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$file
	 * @param	string	$stub
	 * @return	void
	 */
	public function seeSameContentsIn($file, $stub)
	{
		$stub = file_get_contents(__DIR__ . "/../functional/stubs/{$stub}");

		$I = $this->getModule('Filesystem');

		$I->openFile($this->getTemp($file));

		$I->seeFileContentsEqual($stub);
	}

	/**
	 * Check if the given decorators are generated in the given folder.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$folder
	 * @return	void
	 */
	public function seeDecoratorsIn($folder, array $decorators)
	{
		$folder = $this->getTemp($folder);

		$I = $this->getModule('Filesystem');

		foreach ($decorators as $decorator)
		{
			$file = "{$folder}/{$decorator}.php";

			$I->openFile($file);
			$I->seeInThisFile('namespace Workflows\Decorators');
			$I->seeInThisFile("class {$decorator} ");
		}
	}

	/**
	 * Check if a given file has the given namespace.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$file
	 * @param	string	$namespace
	 * @return	void
	 */
	public function seeNamespaceInFile($file, $namespace)
	{
		$I = $this->getModule('Filesystem');

		$I->openFile($this->getTemp($file));

		$I->seeInThisFile("namespace {$namespace};");
	}

	/**
	 * Check if a given file has the given method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$file
	 * @param	string	$method
	 * @return	void
	 */
	public function seeMethodInFile($file, $method)
	{
		$I = $this->getModule('Filesystem');

		$I->openFile($this->getTemp($file));

		$I->seeInThisFile("{$method}(\$data = null)");
	}

	/**
	 * Check if a given file has the given author.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$file
	 * @param	string	$author
	 * @return	void
	 */
	public function seeAuthorInFile($file, $author)
	{
		$I = $this->getModule('Filesystem');

		$I->openFile($this->getTemp($file));

		$I->seeInThisFile("@author		$author");
	}

	/**
	 * Check if a directory exists.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$directory
	 * @return	void
	 */
	public function seeDirectory($directory)
	{
		$I = $this->getModule('Filesystem');

		$path = $this->getTemp($directory);

		$I->seeFileFound($path);
	}

	/**
	 * Check if a directory does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$directory
	 * @return	void
	 */
	public function dontSeeDirectory($directory)
	{
		$I = $this->getModule('Filesystem');

		$path = $this->getTemp($directory);

		$I->dontSeeFileFound($path);
	}

}