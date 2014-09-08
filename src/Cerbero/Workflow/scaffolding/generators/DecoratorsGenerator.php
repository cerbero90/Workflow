<?php namespace Cerbero\Workflow\Scaffolding\Generators;

/**
 * Decorators generator.
 *
 * @author	Andrea Marco Sartori
 */
class DecoratorsGenerator extends AbstractGenerator
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
		$success = true;

		foreach ($data['decorators'] as $decorator)
		{
			$data['decorator'] = $decorator;

			$success = $success && parent::generate($data);
		}
		return $success;
	}

	/**
	 * Retrieve the template name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getTemplate()
	{
		return $this->isValidator() ? 'validator' : 'decorator';
	}

	/**
	 * Retrieve the filename relative to the workflow path.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getFilename()
	{
		extract($this->data);

		return "{$name}/Decorators/{$decorator}.php";
	}

	/**
	 * Determine whether the current decorator is a validator.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	private function isValidator()
	{
		$name = strtolower($this->data['decorator']);

		return starts_with($name, 'validat');
	}

}