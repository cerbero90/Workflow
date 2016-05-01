<?php

namespace spec\Cerbero\Workflow\Console\Drawing;

use Cerbero\Workflow\Console\Drawing\Geometry;
use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;
use PhpSpec\ObjectBehavior;

class DrawerSpec extends ObjectBehavior
{
    public function let(PipelineRepositoryInterface $pipelines)
    {
        $geometry = new Geometry();

        $this->beConstructedWith($pipelines, $geometry);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Console\Drawing\Drawer');
    }

    /**
     * @testdox	It draws a workflow with zero pipes.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_draws_a_workflow_with_zero_pipes($pipelines)
    {
        $pipelines->getPipesByPipeline('RegisterUser')->willReturn([]);

        $drawing = file_get_contents(__DIR__.'/stubs/zero.stub');

        $this->draw('RegisterUser')->shouldReturn($drawing);
    }

    /**
     * @testdox	It draws a workflow with one pipe.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_draws_a_workflow_with_one_pipe($pipelines)
    {
        $pipelines->getPipesByPipeline('RegisterUser')->willReturn(['App\Workflows\RegisterUser\Notifier']);

        $drawing = file_get_contents(__DIR__.'/stubs/one.stub');

        $this->draw('RegisterUser')->shouldReturn($drawing);
    }

    /**
     * @testdox	It draws a workflow with two pipe.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_draws_a_workflow_with_two_pipe($pipelines)
    {
        $pipelines->getPipesByPipeline('RegisterUser')->willReturn(['App\Workflows\RegisterUser\Logger', 'App\Workflows\RegisterUser\Notifier']);

        $drawing = file_get_contents(__DIR__.'/stubs/two.stub');

        $this->draw('RegisterUser')->shouldReturn($drawing);
    }

    /**
     * @testdox	It draws a workflow with many pipes.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function it_draws_a_workflow_with_many_pipes($pipelines)
    {
        $pipelines->getPipesByPipeline('LoginUser')->willReturn(['LongName', 'TheLongestNameEver', 'LongerName', 'Name', 'VeryLongName']);

        $drawing = file_get_contents(__DIR__.'/stubs/many.stub');

        $this->draw('LoginUser')->shouldReturn($drawing);
    }
}
