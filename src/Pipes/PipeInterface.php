<?php namespace Cerbero\Workflow\Pipes;

use \Closure;

/**
 * Interface for pipes.
 *
 * @author	Andrea Marco Sartori
 */
interface PipeInterface {

	/**
	 * Handle the given job.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$job
	 * @param	Closure	$next
	 * @return	mixed
	 */
	public function handle($job, Closure $next);

}
