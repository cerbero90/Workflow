<?php

namespace Cerbero\Workflow\Wrappers;

use ArrayAccess;
use Exception;
use Illuminate\Contracts\Bus\Dispatcher;
use ReflectionClass;
use ReflectionParameter;

/**
 * Wrapper to marshal commands before dispatching them.
 *
 * @author    Andrea Marco Sartori
 */
class MarshalDispatcher implements DispatcherInterface
{
    /**
     * @author    Andrea Marco Sartori
     * @var        Illuminate\Contracts\Bus\Dispatcher    $dispatcher    Bus dispatcher.
     */
    protected $dispatcher;

    /**
     * @author    Andrea Marco Sartori
     * @var        string  $command    Command to dispatch
     */
    protected $command;

    /**
     * @author    Andrea Marco Sartori
     * @var        \ArrayAccess  $source    Parameters from source
     */
    protected $source;

    /**
     * @author    Andrea Marco Sartori
     * @var        array  $extras    Extra parameters
     */
    protected $extras;

    /**
     * Set the dependencies.
     *
     * @author    Andrea Marco Sartori
     * @param    Illuminate\Contracts\Bus\Dispatcher    $dispatcher
     * @return    void
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Set the pipes commands should be piped through before dispatching.
     *
     * @author    Andrea Marco Sartori
     * @param  array  $pipes
     * @return $this
     */
    public function pipeThrough(array $pipes)
    {
        $this->dispatcher->pipeThrough($pipes);

        return $this;
    }

    /**
     * Marshal a command and dispatch it.
     *
     * @author    Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \ArrayAccess  $source
     * @param  array  $extras
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $source, array $extras = [])
    {
        $this->command = $command;
        $this->source  = $source;
        $this->extras  = $extras;

        return $this->dispatcher->dispatch($this->marshal());
    }

    /**
     * Marshal the command to dispatch.
     *
     * @author    Andrea Marco Sartori
     * @return mixed
     */
    protected function marshal()
    {
        $reflection = new ReflectionClass($this->command);

        $constructor = $reflection->getConstructor();

        $params = $this->getParamsToInject($constructor->getParameters());

        return $reflection->newInstanceArgs($params);
    }

    /**
     * Retrieve the arguments to inject into the command constructor.
     *
     * @author    Andrea Marco Sartori
     * @param    array    $parameters
     * @return    array
     */
    protected function getParamsToInject(array $parameters)
    {
        return array_map(function ($parameter) {
            return $this->grabParameter($parameter);

        }, $parameters);
    }

    /**
     * Get a parameter value for a marshaled command.
     *
     * @author    Andrea Marco Sartori
     * @param  \ReflectionParameter  $parameter
     * @return mixed
     */
    protected function grabParameter(ReflectionParameter $parameter)
    {
        if (isset($this->extras[$parameter->name])) {
            return $this->extras[$parameter->name];
        }

        if (isset($this->values[$parameter->name])) {
            return $this->values[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception("Unable to map parameter [{$parameter->name}] to command [{$this->command}]");
    }
}
