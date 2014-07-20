<?php namespace Cerbero\Workflow\Scaffolding;

use Cerbero\Workflow\WorkflowDataTransfer as Workflow;

/**
 * Scaffolding generator interface.
 *
 * @author	Andrea Marco Sartori
 */
interface GeneratorInterface
{

	/**
	 * Generate the scaffolding.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\WorkflowDataTransfer	$workflow
	 * @return	void
	 */
	public function generate(Workflow $workflow);

}