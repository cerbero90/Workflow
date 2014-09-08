<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Bindings file generator.
 *
 * @author	Andrea Marco Sartori
 */
class BindingsGenerator extends AbstractGenerator
{

	/**
	 * Generate the scaffolding files.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	boolean
	 */
	public function generate(array $data)
	{
		$this->data = $data;

		while ( ! $this->workflowIsBound())
		{
			parent::generate($data);

			$this->append = ! $this->append;
		}
		return true;
	}

	/**
	 * Retrieve the template name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getTemplate()
	{
		return $this->append ? 'bindings' : 'empty';
	}

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getFilename()
	{
		return 'bindings.php';
	}

	/**
	 * Determine whether the current workflow has been already bound.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	private function workflowIsBound()
	{
		if( ! $this->alreadyExists()) return false;

		$content = $this->file->get($this->getPath());

		extract($this->data);

		$interface = "{$namespace}\\{$name}Interface";

		return str_contains($content, $interface);
	}

}