<?php namespace Cerbero\Workflow\Scaffolding;

use Cerbero\Workflow\WorkflowDataTransfer as Workflow;

/**
 * Template compiler interface.
 *
 * @author	Andrea Marco Sartori
 */
interface CompilerInterface
{

	/**
	 * Compile the template.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$template
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @return	string
	 */
	public function compile($template, Workflow $workflow);

}