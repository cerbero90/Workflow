<?php namespace Cerbero\Workflow\Wrappers;

use Illuminate\Contracts\Bus\Dispatcher;

/**
 * Interface for letting dispatcher use pipelines.
 *
 * @author	Andrea Marco Sartori
 */
interface PipingDispatcherInterface extends Dispatcher {

	/**
	 * Set the pipes commands should be piped through before dispatching.
	 *
	 * @param  array  $pipes
	 * @return $this
	 */
	public function pipeThrough(array $pipes);

}
