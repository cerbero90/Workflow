<?php

namespace Cerbero\Workflow\Wrappers;

/**
 * Interface for YAML file parsers.
 *
 * @author	Andrea Marco Sartori
 */
interface YamlParserInterface
{
    /**
     * Parse the given YAML file.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $path
     *
     * @return array
     */
    public function parse($path);

    /**
     * Dump the given array to YAML string.
     *
     * @author	Andrea Marco Sartori
     *
     * @param array $data
     *
     * @return string
     */
    public function dump(array $data);
}
