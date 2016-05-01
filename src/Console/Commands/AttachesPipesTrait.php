<?php

namespace Cerbero\Workflow\Console\Commands;

/**
 * Trait to attach pipes to pipelines.
 *
 * @author    Andrea Marco Sartori
 */
trait AttachesPipesTrait
{
    /**
     * @author    Andrea Marco Sartori
     *
     * @var string $currentPipe    Pipe to generate.
     */
    protected $currentPipe;

    /**
     * Generate the specified pipes.
     *
     * @author    Andrea Marco Sartori
     *
     * @return void
     */
    protected function generatePipes()
    {
        foreach ($this->getPipesByOption('attach') as $pipe) {
            $this->currentPipe = $pipe;

            parent::fire();
        }
    }

    /**
     * Retrieve a list of pipes.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $option
     *
     * @return array
     */
    protected function getPipesByOption($option)
    {
        $pipes = $this->option($option);

        preg_match_all('/\w+/', $pipes, $matches);

        return array_map('ucfirst', $matches[0]);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $workflows = $this->getWorkflowsNamespace();

        $pipeline = $this->getWorkflowName();

        return "{$rootNamespace}\\{$workflows}\\{$pipeline}";
    }

    /**
     * Retrieve the namespace of the workflows.
     *
     * @author    Andrea Marco Sartori
     *
     * @return string
     */
    protected function getWorkflowsNamespace()
    {
        $relative = ltrim(config('workflow.path'), app_path());

        $chunks = array_map('ucfirst', explode('/', $relative));

        return implode('\\', $chunks);
    }

    /**
     * Retrieve a list of pipes with their namespaces.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $option
     *
     * @return array
     */
    protected function getNamespacedPipesByOption($option)
    {
        return array_map([$this, 'parseName'], $this->getPipesByOption($option));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->currentPipe;
    }
}
