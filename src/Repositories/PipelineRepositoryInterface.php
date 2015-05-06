<?php namespace Cerbero\Workflow\Repositories;

/**
 * Interface for pipeline repositories.
 *
 * @author	Andrea Marco Sartori
 */
interface PipelineRepositoryInterface {

	/**
	 * Retrieve the source of the pipelines.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getSource();

	/**
	 * Determine whether a given pipeline exists.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipeline
	 * @return	boolean
	 */
	public function exists($pipeline);

	/**
	 * Retrieve the pipes of a given pipeline.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipeline
	 * @return	array
	 */
	public function getPipesByPipeline($pipeline);

	/**
	 * Create the pipelines storage.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function settle();

	/**
	 * Store the given pipeline and its pipes.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipeline
	 * @param	array	$pipes
	 * @return	void
	 */
	public function store($pipeline, array $pipes);

	/**
	 * Update the given pipeline and its pipes.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipeline
	 * @param	array	$attachments
	 * @param	array	$detachments
	 * @return	void
	 */
	public function update($pipeline, array $attachments, array $detachments);

	/**
	 * Destroy a given pipeline.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$pipeline
	 * @return	void
	 */
	public function destroy($pipeline);

}
