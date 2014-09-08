<?php namespace Cerbero\Workflow\Scaffolding\TemplateEngines;

/**
 * Interface for template engines.
 *
 * @author	Andrea Marco Sartori
 */
interface TemplateEngineInterface
{

	/**
	 * Render the template with custom values.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @param	array	$data
	 * @return	string
	 */
	public function render($template, array $data);

}