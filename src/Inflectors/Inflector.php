<?php namespace Cerbero\Workflow\Inflectors;

use Cerbero\Workflow\Wrappers\NamespaceDetectorInterface;

/**
 * Word inflector.
 *
 * @author	Andrea Marco Sartori
 */
class Inflector implements InflectorInterface {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$word	Word to inflect.
	 */
	protected $word;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$namespace	The application namespace.
	 */
	protected $namespace;
	
	/**
	 * Set the application namespace.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\Wrappers\NamespaceDetectorInterface	$detector	Application namespace detector.
	 * @return	void
	 */
	public function __construct(NamespaceDetectorInterface $detector)
	{
		$this->namespace = $detector->detect();
	}

	/**
	 * Set the word to inflect.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$word
	 * @return	$this
	 */
	public function of($word)
	{
		$this->word = $word;

		return $this;
	}

	/**
	 * Retrieve the inflected request.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getRequest()
	{
		return $this->compose('Request', 'Http\Requests');
	}

	/**
	 * Compose the word to inflect.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$suffix
	 * @param	string	$path
	 * @return	string
	 */
	protected function compose($suffix, $path)
	{
		$name = ucfirst($this->word) . $suffix;

		return $this->namespace . "\\{$path}\\{$name}";
	}

	/**
	 * Retrieve the inflected job.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getJob()
	{
		return $this->compose('Job', 'Jobs');
	}

}
