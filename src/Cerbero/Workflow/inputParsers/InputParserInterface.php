<?php namespace Cerbero\Workflow\InputParsers;

/**
 * Interface for command input parsers.
 *
 * @author	Andrea Marco Sartori
 */
interface InputParserInterface
{

	/**
	 * Parse the input of the command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$input
	 * @return	array
	 */
	public function parse(array $input);

}