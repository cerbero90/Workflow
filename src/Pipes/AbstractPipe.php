<?php

namespace Cerbero\Workflow\Pipes;

use Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Abstract implementation of a pipe.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractPipe implements PipeInterface
{
    /**
     * @author	Andrea Marco Sartori
     *
     * @var Illuminate\Contracts\Container\Container $container	Service container.
     */
    protected $container;

    /**
     * Set the dependencies.
     *
     * @author	Andrea Marco Sartori
     *
     * @param Illuminate\Contracts\Container\Container $container
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle the given job.
     *
     * @author	Andrea Marco Sartori
     *
     * @param mixed   $job
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($job, Closure $next)
    {
        $this->callBefore($job);

        $handled = $next($job);

        $this->callAfter($handled, $job);

        return $handled;
    }

    /**
     * Call the before method.
     *
     * @author	Andrea Marco Sartori
     *
     * @param Cerbero\Jobs\Job $job
     *
     * @return void
     */
    protected function callBefore($job)
    {
        $this->callIfExists('before', [$job]);
    }

    /**
     * Call a method if it exists and resolve its dependencies.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return void
     */
    private function callIfExists($method, array $parameters = [])
    {
        if (method_exists($this, $method)) {
            $this->container->call([$this, $method], $parameters);
        }
    }

    /**
     * Call the after method.
     *
     * @author	Andrea Marco Sartori
     *
     * @param mixed            $handled
     * @param Cerbero\Jobs\Job $job
     *
     * @return void
     */
    protected function callAfter($handled, $job)
    {
        $this->callIfExists('after', [$handled, $job]);
    }
}
