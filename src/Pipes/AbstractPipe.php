<?php namespace Cerbero\Workflow\Pipes;

use \Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Abstract implementation of a pipe.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractPipe implements PipeInterface {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Container\Container	$container	Service container.
	 */
	protected $container;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Container\Container	$container
	 * @return	void
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Handle the given command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$command
	 * @param	Closure	$next
	 * @return	mixed
	 */
	public function handle($command, Closure $next)
	{
		$this->callBefore($command);

		$handled = $next($command);

		$this->callAfter($handled, $command);

		return $handled;
	}

	/**
	 * Call the before method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Commands\Command	$command
	 * @return	void
	 */
	protected function callBefore($command)
	{
		$this->callIfExists('before', [$command]);
	}

	/**
	 * Call a method if it exists and resolve its dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$method
	 * @param	array	$parameters
	 * @return	void
	 */
	private function callIfExists($method, array $parameters = [])
	{
		if(method_exists($this, $method))
		{
			$this->container->call([$this, $method], $parameters);
		}
	}

	/**
	 * Call the after method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$handled
	 * @param	Cerbero\Commands\Command	$command
	 * @return	void
	 */
	protected function callAfter($handled, $command)
	{
		$this->callIfExists('after', [$handled, $command]);
	}

}
