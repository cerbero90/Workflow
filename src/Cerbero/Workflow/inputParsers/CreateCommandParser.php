<?php namespace Cerbero\Workflow\InputParsers;

/**
 * Input parser for the Create command.
 *
 * @author	Andrea Marco Sartori
 */
class CreateCommandParser extends AbstractInputParser
{

	/**
	 * Retrieve the new array structure.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$input
	 * @return	array
	 */
	protected function getStructure($input)
	{
		return array
		(
			'name' => ucfirst($input['name']),

			'namespace' => $this->parseNamespace($input['namespace']),

			'path' => str_replace('\\', '/', $input['path']),

			'decorators' => $this->parseDecorators($input['decorators']),

			'method' => rtrim($input['method'], '()'),

			'lowername' => lcfirst($input['name']),

			'author' => $input['author'],
		);
	}

	/**
	 * Parse the namespace.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$namespace
	 * @return	string
	 */
	private function parseNamespace($namespace)
	{
		$backslashed = str_replace('/', '\\', $namespace);

		$trimmed = rtrim($backslashed, '\\');

		$chunks = explode('\\', $trimmed);

		$capitalized = array_map('ucfirst', $chunks);

		return implode('\\', $capitalized);
	}

	/**
	 * Parse the decorators.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$decorators
	 * @return	array
	 */
	private function parseDecorators($decorators)
	{
		preg_match_all('/\w+/', $decorators, $matches);

		return array_map('ucfirst', $matches[0]);
	}

}