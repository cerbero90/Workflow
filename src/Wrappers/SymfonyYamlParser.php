<?php namespace Cerbero\Workflow\Wrappers;

use Symfony\Component\Yaml\Yaml;

/**
 * Symfony YAML files parser.
 *
 * @author	Andrea Marco Sartori
 */
class SymfonyYamlParser implements YamlParserInterface {

	/**
	 * Parse the given YAML file.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$path
	 * @return	array
	 */
	public function parse($path)
	{
		return Yaml::parse($path);
	}

	/**
	 * Dump the given array to YAML string.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	string
	 */
	public function dump(array $data)
	{
		return Yaml::dump($data);
	}

}