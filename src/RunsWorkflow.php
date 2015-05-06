<?php namespace Cerbero\Workflow;

/**
 * Trait to set the workflow.
 *
 * @author	Andrea Marco Sartori
 */
trait RunsWorkflow {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Workflow\Workflow	$workflow	Workflows hub.
	 */
	protected $workflow;

	/**
	 * Set the workflow to run.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Workflow\Workflow	$workflow
	 * @return	void
	 */
	public function setWorkflow(Workflow $workflow)
	{
		$this->workflow = $workflow;
	}

}
