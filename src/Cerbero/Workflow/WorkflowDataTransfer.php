<?php namespace Cerbero\Workflow;

use Illuminate\Support\Facades\Config;

/**
 * Data transfer object to create workflows.
 *
 * @author	Andrea Marco Sartori
 */
class WorkflowDataTransfer
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$data	Workflow data.
	 */
	protected $data;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	void
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Retrieve data dynamically.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$attribute
	 * @return	mixed
	 */
	public function __get($attribute)
	{
		$method = 'get' . ucfirst($attribute);

		if(method_exists($this, $method)) return $this->{$method}();

		return $this->data[$attribute];
	}

	/**
	 * Set the method to trigger the workflow.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$method
	 * @return	void
	 */
	public function setMethod($method)
	{
		$this->data['method'] = $method;

		return $this;
	}

	/**
	 * Set the decorators.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$decorators
	 * @return	void
	 */
	public function setDecorators($decorators)
	{
		preg_match_all('/([a-z]+)/i', $decorators, $matches);

		$this->data['decorators'] = array_map('ucfirst', $matches[0]);

		return $this;
	}

	/**
	 * Retrieve the workflow name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getName()
	{
		$name = $this->data['name'];

		return ucfirst($name);
	}

	/**
	 * Retrieve the workflow folder.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getFolder()
	{
		return Config::get('workflow::folder');
	}

	/**
	 * Retrieve the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getPath()
	{
		$path = app_path() . "/{$this->folder}/{$this->name}";

		return str_replace('//', '/', $path);
	}

	/**
	 * Retrieve the workflow namespace.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getNamespace()
	{
		$chunks = [Config::get('workflow::namespace'), ucfirst($this->folder), $this->name];

		$namespace = ltrim(implode('\\', $chunks), '\\');

		return str_replace('\\\\', '\\', $namespace);
	}

	/**
	 * Retrieve the lower cased name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getLowername()
	{
		return lcfirst($this->name);
	}

}