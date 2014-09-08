<?php

namespace spec\Cerbero\Workflow\Scaffolding\TemplateEngines\Blade;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\View\Factory;
use Illuminate\View\View;

class BladeTemplateEngineSpec extends ObjectBehavior
{

	function let(Factory $factory, View $view)
	{
		$this->beConstructedWith($factory);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\TemplateEngines\Blade\BladeTemplateEngine');
    }

    /**
     * @testdox	It renders the given template with the given data.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_renders_the_given_template_with_the_given_data($factory, $view)
    {
    	$factory->make('template', ['foo' => 'bar'])->shouldBeCalled()->willReturn($view);

    	$view->render()->shouldBeCalled()->willReturn('rendered_template');

    	$this->render('template', ['foo' => 'bar'])->shouldReturn('rendered_template');
    }
}
