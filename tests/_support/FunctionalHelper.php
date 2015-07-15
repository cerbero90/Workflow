<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module {

	/**
	 * Dynamically get modules.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$name
	 * @return	mixed
	 */
	public function __get($name)
	{
		$module = ucfirst($name);

		return $this->getModule($module);
	}

	/**
	 * Run an Artisan command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$command
	 * @return	void
	 */
	public function runArtisan($command)
	{
		$this->filesystem->amInPath(base_path());

		$this->cli->runShellCommand("php artisan {$command}");
	}

	/**
	 * Check if the content of a generated job is equal to the given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$job
	 * @param	string	$stub
	 * @return	void
	 */
	public function seeInJob($job, $stub)
	{
		$file = "Jobs/{$job}.php";

		$this->seeStubInFile($file, $stub);
	}

	/**
	 * Check if the content of a generated request is equal to the given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$request
	 * @param	string	$stub
	 * @return	void
	 */
	public function seeInRequest($request, $stub)
	{
		$file = "Http/Requests/{$request}.php";

		$this->seeStubInFile($file, $stub);
	}

	/**
	 * Check if the content of a generated pipe is equal to the given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipe
	 * @param	string	$stub
	 * @param	string	$path
	 * @return	void
	 */
	public function seeInPipe($pipe, $stub, $path = 'Workflows')
	{
		$file = "{$path}/{$pipe}.php";

		$this->seeStubInFile($file, $stub);
	}

	/**
	 * Check if the content of the generated workflows list is equal to the given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$stub
	 * @param	string	$path
	 * @return	void
	 */
	public function seeInWorkflows($stub, $path = 'Workflows')
	{
		$file = "{$path}/workflows.yml";

		$this->seeStubInFile($file, $stub);
	}

	/**
	 * Check if the content of a file is equal to the given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$file
	 * @param	string	$stub
	 * @return	void
	 */
	public function seeStubInFile($file, $stub)
	{
		$I = $this->filesystem;

		$I->openFile(app_path($file));

		$content = $this->getContentOfStub($stub);

		$I->seeFileContentsEqual($content);
	}

	/**
	 * Retrieve the content of a stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$stub
	 * @return	string
	 */
	protected function getContentOfStub($stub)
	{
		$path = __DIR__ . "/stubs/{$stub}";

		return file_get_contents($path);
	}

	/**
	 * Remove all the generated files for a given workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$workflow
	 * @param	string	$path
	 * @return	void
	 */
	public function clearWorkflow($workflow, $path = "Workflows")
	{
		$this->deleteDirIfExists($path);

		$this->deleteFileIfExists("Jobs/{$workflow}Job.php");

		$this->deleteFileIfExists("Http/Requests/{$workflow}Request.php");
	}

	/**
	 * Delete a directory if exists.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @return	void
	 */
	protected function deleteDirIfExists($path)
	{
		if(file_exists($dir = app_path($path)))
		{
			$this->filesystem->deleteDir($dir);
		}
	}

	/**
	 * Delete a file if exists.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @return	void
	 */
	protected function deleteFileIfExists($path)
	{
		if(file_exists($file = app_path($path)))
		{
			$this->filesystem->deleteFile($file);
		}
	}

	/**
	 * Assert a given request does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$request
	 * @return	void
	 */
	public function dontSeeRequest($request)
	{
		$file = app_path("Http/Requests/{$request}.php");

		$this->filesystem->dontSeeFileFound($file);
	}

	/**
	 * Assert a given pipe does exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipe
	 * @param	string	$path
	 * @return	void
	 */
	public function seePipe($pipe, $path = 'Workflows')
	{
		$file = app_path("{$path}/{$pipe}.php");

		$this->filesystem->seeFileFound($file);
	}

	/**
	 * Assert a given pipe does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipe
	 * @param	string	$path
	 * @return	void
	 */
	public function dontSeePipe($pipe, $path = 'Workflows')
	{
		$file = app_path("{$path}/{$pipe}.php");

		$this->filesystem->dontSeeFileFound($file);
	}

	/**
	 * Assert a given job does exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$job
	 * @param	string	$path
	 * @return	void
	 */
	public function seeJob($job, $path = 'Jobs')
	{
		$file = app_path("{$path}/{$job}.php");

		$this->filesystem->seeFileFound($file);
	}

	/**
	 * Assert a given job does not exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$job
	 * @param	string	$path
	 * @return	void
	 */
	public function dontSeeJob($job, $path = 'Jobs')
	{
		$file = app_path("{$path}/{$job}.php");

		$this->filesystem->dontSeeFileFound($file);
	}

	/**
	 * Assert a given request does exist.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$request
	 * @param	string	$path
	 * @return	void
	 */
	public function seeRequest($request, $path = 'Http/Requests')
	{
		$file = app_path("{$path}/{$request}.php");

		$this->filesystem->seeFileFound($file);
	}

	/**
	 * Check if a drawing is identical to a given stub.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$stub
	 * @return	void
	 */
	public function seeDrawingIs($stub)
	{
		$content = $this->getContentOfStub("Drawings/$stub");

		$this->cli->seeInShellOutput($content);
	}

}
