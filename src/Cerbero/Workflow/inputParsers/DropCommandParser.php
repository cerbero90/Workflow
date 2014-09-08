<?php namespace Cerbero\Workflow\InputParsers;

/**
 * Drop command input parser.
 *
 * @author	Andrea Marco Sartori
 */
class DropCommandParser extends AbstractInputParser
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

			'path' => $this->parsePath($input['path']),
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
	 * Parse the path.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @return	string
	 */
	private function parsePath($path)
	{
		$slashed = str_replace('\\', '/', $path);

		return rtrim($slashed, '/');
	}

}