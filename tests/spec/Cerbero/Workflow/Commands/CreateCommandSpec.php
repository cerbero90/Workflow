<?php

namespace spec\Cerbero\Workflow\Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Config\Repository as Config;
use Cerbero\Workflow\InputParsers\InputParserInterface;
use Cerbero\Workflow\Scaffolding\Builders\BuilderInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class CreateCommandSpec extends ObjectBehavior
{

	function let(Config $config, InputParserInterface $parser, BuilderInterface $builder)
	{
		$this->beConstructedWith($config, $parser, $builder);
	}

	function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Commands\CreateCommand');
    }

    /**
     * @testdox	It fires the command.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_fires_the_command($parser, $builder)
    {
    	$parser->parse(Argument::withKey('name'))->shouldBeCalled()->willReturn(['name' => 'foo']);

    	$builder->build(['name' => 'foo'])->shouldBeCalled();

    	$this->run(new ArrayInput(['name' => 'foo']), new NullOutput);
    }
}
