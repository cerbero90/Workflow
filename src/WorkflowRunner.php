<?php namespace Cerbero\Workflow;

/**
 * Interface for classes that run workflow.
 *
 * @author	Andrea Marco Sartori
 */
interface WorkflowRunner {

	/**
	 * Set the workflows to run.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\Workflow	$workflow
	 * @return	void
	 */
	public function setWorkflow(Workflow $workflow);

}
