<?php namespace Cerbero\Workflow\Pipes;

use \Closure;

/**
 * Interface for pipes.
 *
 * @author	Andrea Marco Sartori
 */
interface PipeInterface {

	/**
	 * Handle the given command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$command
	 * @param	Closure	$next
	 * @return	mixed
	 */
	public function handle($command, Closure $next);

}
