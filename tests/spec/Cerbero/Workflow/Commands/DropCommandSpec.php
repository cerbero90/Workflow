<?php

namespace spec\Cerbero\Workflow\Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Cerbero\Workflow\Scaffolding\Editors\BindingsEditorInterface as Editor;
use Cerbero\Workflow\InputParsers\InputParserInterface as Parser;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DropCommandSpec extends ObjectBehavior
{

	function let(Config $config, Parser $parser, Filesystem $file, Editor $editor)
	{
		$this->beConstructedWith($config, $parser, $file, $editor);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Commands\DropCommand');
    }

    /**
     * @testdox	It fires the command.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_fires_the_command($parser, $file, $editor)
    {
    	$parser->parse(Argument::withKey('name'))->shouldBeCalled()->willReturn(['name' => 'foo', 'namespace' => 'Bar\Baz', 'path' => 'bar/baz']);

    	$file->deleteDirectory('bar/baz/foo')->shouldBeCalled()->willReturn(true);

    	$editor->removeWorkflow('foo', 'Bar\Baz', 'bar/baz')->shouldBeCalled()->willReturn(true);

    	$this->run(new ArrayInput(['name' => 'foo', '--namespace' => 'Bar\Baz', '--path' => 'bar/baz']), new NullOutput);
    }
}
