<?php namespace Cerbero\Workflow\InputParsers;

/**
 * Command input parser.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractInputParser implements InputParserInterface
{

	/**
	 * Parse the input of the command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$input
	 * @return	array
	 */
	public function parse(array $input)
	{
		$data = array_map([$this, 'getStructure'], [$input]);

		return current($data);
	}

	/**
	 * Retrieve the new array structure.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$input
	 * @return	array
	 */
	abstract protected function getStructure($input);

}