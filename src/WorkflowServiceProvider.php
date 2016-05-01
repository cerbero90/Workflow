<?php

namespace Cerbero\Workflow;

use Cerbero\Workflow\Facades\Workflow as Facade;
use Cerbero\Workflow\Inflectors\Inflector;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Cerbero\Workflow\Repositories\YamlPipelineRepository;
use Cerbero\Workflow\Workflow;
use Cerbero\Workflow\WorkflowRunner;
use Cerbero\Workflow\Wrappers\DispatcherInterface;
use Cerbero\Workflow\Wrappers\MarshalDispatcher;
use Cerbero\Workflow\Wrappers\SymfonyYamlParser;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Workflow service provider.
 *
 * @author    Andrea Marco Sartori
 */
class WorkflowServiceProvider extends ServiceProvider {

    /**
     * @author    Andrea Marco Sartori
     * @var        array    $commands    List of registered commands.
     */
    protected $commands = [
        'cerbero.workflow.create',
        'cerbero.workflow.read',
        'cerbero.workflow.update',
        'cerbero.workflow.delete',
    ];

    /**
     * Boot the package up.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function boot()
    {
        $this->publishConfig();

        $this->commands($this->commands);

        AliasLoader::getInstance()->alias('Workflow', Facade::class);
    }

    /**
     * Publish the configuration file.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function publishConfig()
    {
        $config = __DIR__ . '/config/workflow.php';

        $this->publishes([$config => config_path('workflow.php')]);

        $this->mergeConfigFrom($config, 'workflow');
    }

    /**
     * Register the services.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function register()
    {
        $this->registerPipelineRepository();

        $this->registerInflector();

        $this->registerDispatcher();

        $this->registerWorkflow();

        $this->registerWorkflowRunnersHook();

        $this->registerCommands();

        $this->registerAppWorkflowProvider();
    }

    /**
     * Register the pipeline repository.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerPipelineRepository()
    {
        $this->app->bind(PipelineRepositoryInterface::class, function($app) {
            return new YamlPipelineRepository(
                new SymfonyYamlParser,

                new \Illuminate\Filesystem\Filesystem,

                config('workflow.path')
            );
        });
    }

    /**
     * Register the inflector.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerInflector()
    {
        $this->app->bind(InflectorInterface::class, function($app) {
            return new Inflector($app->getNamespace());
        });
    }

    /**
     * Register the bus dispatcher.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerDispatcher()
    {
        $this->app->bind(DispatcherInterface::class, MarshalDispatcher::class);
    }

    /**
     * Register the package main class.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerWorkflow()
    {
        $this->app->singleton('cerbero.workflow', Workflow::class);
    }

    /**
     * Register the hook for the workflow runners.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerWorkflowRunnersHook()
    {
        $this->app->afterResolving(function(WorkflowRunner $runner, $app) {
            $runner->setWorkflow($app['cerbero.workflow']);
        });
    }

    /**
     * Register the console commands.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerCommands()
    {
        foreach ($this->commands as $command) {
            $name = ucfirst(last(explode('.', $command)));

            $this->app->singleton($command, function($app) use($name) {
                return $app["Cerbero\Workflow\Console\Commands\\{$name}WorkflowCommand"];
            });
        }
    }

    /**
     * Register the service provider for the application workflows.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    private function registerAppWorkflowProvider()
    {
        $provider = $this->app->getNamespace() . 'Providers\WorkflowsServiceProvider';

        if (class_exists($provider)) {
            $this->app[$provider]->register();
        }
    }
}
