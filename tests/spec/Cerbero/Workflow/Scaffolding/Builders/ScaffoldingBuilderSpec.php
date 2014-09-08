<?php

namespace spec\Cerbero\Workflow\Scaffolding\Builders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Workflow\Scaffolding\Generators\GeneratorInterface;

class ScaffoldingBuilderSpec extends ObjectBehavior
{

	function let(GeneratorInterface $gen1, GeneratorInterface $gen2)
	{
		$this->beConstructedWith([$gen1, $gen2]);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Builders\ScaffoldingBuilder');
    }

    /**
     * @testdox	It builds the scaffolding.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_builds_the_scaffolding($gen1, $gen2)
    {
    	$gen1->generate(['foo'])->shouldBeCalled()->willReturn(true);

    	$gen2->generate(['foo'])->shouldBeCalled()->willReturn(true);

    	$this->build(['foo'])->shouldReturn(true);
    }

    /**
     * @testdox	It returns false if at least one generator fails.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_false_if_at_least_one_generator_fails($gen1, $gen2)
    {
    	$gen1->generate(['foo'])->shouldBeCalled()->willReturn(true);

    	$gen2->generate(['foo'])->shouldBeCalled()->willReturn(false);

    	$this->build(['foo'])->shouldReturn(false);
    }
}
