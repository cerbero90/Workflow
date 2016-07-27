<?php

namespace spec\Cerbero\Workflow;

use ArrayAccess;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Cerbero\Workflow\Wrappers\DispatcherInterface;
use Illuminate\Contracts\Container\Container;
use PhpSpec\ObjectBehavior;

class WorkflowSpec extends ObjectBehavior
{
    public function let(
        PipelineRepositoryInterface $pipelines,
        InflectorInterface $inflector,
        Container $container,
        DispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($pipelines, $inflector, $container, $dispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Workflow');
    }

    /**
     * @testdox	It throws an exception if a workflow does not exist.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_throws_an_exception_if_a_workflow_does_not_exist($pipelines)
    {
        $pipelines->exists('unknownWorkflow')->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('BadFunctionCallException')->duringUnknownWorkflow();
    }

    /**
     * @testdox	It resolves the proper request if existing.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_resolves_the_proper_request_if_existing($pipelines, $container, Router $router, $inflector, $dispatcher, ExistingRequest $request)
    {
        $pipelines->exists('registerUser')->willReturn(true);

        $inflector->of('registerUser')->shouldBeCalled();

        $inflector->getRequest()->willReturn('spec\Cerbero\Workflow\ExistingRequest');

        $container->make('spec\Cerbero\Workflow\ExistingRequest')->shouldBeCalled()->willReturn($request);

        $container->make('router')->willReturn($router);

        $router->current()->willReturn($router);

        $router->parameters()->willReturn(['foo' => 'bar']);

        $inflector->getJob()->willReturn('job');

        $pipelines->getPipesByPipeline('registerUser')->willReturn(['pipe']);

        $dispatcher->pipeThrough(['pipe'])->willReturn($dispatcher);

        $dispatcher->dispatchFrom('job', $request, ['foo' => 'bar'])->shouldBeCalled();

        $this->registerUser();
    }

    /**
     * @testdox	It dispatches a job through a pipeline from a default request.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_dispatches_a_job_through_a_pipeline_from_a_default_request($pipelines, $container, Router $router, $inflector, $dispatcher, ArrayAccess $request)
    {
        $pipelines->exists('registerUser')->willReturn(true);

        $inflector->of('registerUser')->shouldBeCalled();

        $inflector->getRequest()->willReturn('NotExistingRequest');

        $container->make('Illuminate\Http\Request')->shouldBeCalled()->willReturn($request);

        $container->make('router')->willReturn($router);

        $router->current()->willReturn($router);

        $router->parameters()->willReturn(['foo' => 'bar']);

        $inflector->getJob()->willReturn('job');

        $pipelines->getPipesByPipeline('registerUser')->willReturn(['pipe']);

        $dispatcher->pipeThrough(['pipe'])->willReturn($dispatcher);

        $dispatcher->dispatchFrom('job', $request, ['foo' => 'bar'])->shouldBeCalled();

        $this->registerUser('foo', 'bar');
    }
}


abstract class ExistingRequest implements ArrayAccess
{
}

interface Router
{
    public function current();

    public function parameters();
}
