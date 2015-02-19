<?php

namespace spec\Cerbero\Workflow;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use Cerbero\Workflow\Wrappers\PipingDispatcherInterface;
use Cerbero\Workflow\Inflectors\InflectorInterface;
use Illuminate\Contracts\Container\Container;
use ArrayAccess;

class WorkflowSpec extends ObjectBehavior {

	public function let(
		PipelineRepositoryInterface $pipelines,
		PipingDispatcherInterface $dispatcher,
		InflectorInterface $inflector,
		Container $container
	) {
		$this->beConstructedWith($pipelines, $dispatcher, $inflector, $container);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Workflow');
    }

    /**
     * @testdox	It throws an exception if a workflow does not exist.
     *
     * @author	Andrea Marco Sartori
     * @return	void
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
     * @return	void
     */
    public function it_resolves_the_proper_request_if_existing($pipelines, $container, $inflector, $dispatcher, ExistingRequest $request)
    {
    	$pipelines->exists('registerUser')->willReturn(true);

    	$inflector->of('registerUser')->shouldBeCalled();

    	$inflector->getRequest()->willReturn('spec\Cerbero\Workflow\ExistingRequest');

    	$container->make('spec\Cerbero\Workflow\ExistingRequest')->shouldBeCalled()->willReturn($request);

    	$inflector->getCommand()->willReturn('command');

    	$pipelines->getPipesByPipeline('registerUser')->willReturn(['pipe']);

    	$dispatcher->pipeThrough(['pipe'])->willReturn($dispatcher);

    	$dispatcher->dispatchFrom('command', $request)->shouldBeCalled();

    	$this->registerUser();
    }

    /**
     * @testdox	It dispatches a command through a pipeline from a default request.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_dispatches_a_command_through_a_pipeline_from_a_default_request($pipelines, $container, $inflector, $dispatcher, ArrayAccess $request)
    {
    	$pipelines->exists('registerUser')->willReturn(true);

    	$inflector->of('registerUser')->shouldBeCalled();

    	$inflector->getRequest()->willReturn('NotExistingRequest');

    	$container->make('Illuminate\Http\Request')->shouldBeCalled()->willReturn($request);

    	$inflector->getCommand()->willReturn('command');

    	$pipelines->getPipesByPipeline('registerUser')->willReturn(['pipe']);

    	$dispatcher->pipeThrough(['pipe'])->willReturn($dispatcher);

    	$dispatcher->dispatchFrom('command', $request)->shouldBeCalled();

    	$this->registerUser();
    }

}


abstract class ExistingRequest implements ArrayAccess {}