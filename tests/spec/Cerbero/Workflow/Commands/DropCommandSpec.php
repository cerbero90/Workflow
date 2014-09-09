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
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DropCommandSpec extends ObjectBehavior
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		QuestionHelper	$question	Question helper.
	 */
	private $question;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		HelperSet	$helpers	Helper set.
	 */
	private $helpers;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		ArrayInput	$input	Array of input.
	 */
	private $input;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		NullOutput	$output	Null output.
	 */
	private $output;

	function let(Config $config, Parser $parser, Filesystem $file, Editor $editor, QuestionHelper $question, HelperSet $helpers)
	{
		$this->beConstructedWith($config, $parser, $file, $editor);

		$this->question = $question;

		$this->helpers = $helpers;

        $this->input = new ArrayInput(['name' => 'foo', '--namespace' => 'Bar\Baz', '--path' => 'bar/baz']);

        $this->output = new NullOutput;
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Commands\DropCommand');
    }

    /**
     * @testdox	It drops an existing workflow if the user confirms.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_drops_an_existing_workflow_if_the_user_confirms($parser, $file, $editor)
    {
    	$parser->parse(Argument::withKey('name'))->shouldBeCalled()->willReturn(['name' => 'Foo', 'namespace' => 'Bar\Baz', 'path' => 'bar/baz']);

    	$this->assertUserConfirms();

    	$file->deleteDirectory('bar/baz/Foo')->shouldBeCalled()->willReturn(true);

    	$editor->removeWorkflow('Foo', 'Bar\Baz', 'bar/baz')->shouldBeCalled()->willReturn(true);

    	$this->run($this->input, $this->output);
    }

    /**
     * @testdox	It skips the workflow dropping if the user does not confirm.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_skips_the_workflow_dropping_if_the_user_does_not_confirm($parser, $file, $editor)
    {
    	$parser->parse(Argument::withKey('name'))->shouldBeCalled()->willReturn(['name' => 'Foo', 'namespace' => 'Bar\Baz', 'path' => 'bar/baz']);
    	
    	$this->assertUserDoesNotConfirm();

    	$file->deleteDirectory('bar/baz/Foo')->shouldNotBeCalled();

    	$editor->removeWorkflow('Foo', 'Bar\Baz', 'bar/baz')->shouldNotBeCalled();

    	$this->run($this->input, $this->output);
    }

    /**
     * Assert the user confirms the operation.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    private function assertUserConfirms()
    {
        $this->handleConfirmation(true);
    }

    /**
     * Assert the user does not confirm the operation.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    private function assertUserDoesNotConfirm()
    {
        $this->handleConfirmation(false);
    }

    /**
     * Handle the confirmation dialog.
     *
     * @author	Andrea Marco Sartori
     * @param	boolean	$confirm
     * @return	void
     */
    private function handleConfirmation($confirm)
    {
    	$query = Argument::type('Symfony\Component\Console\Question\ConfirmationQuestion');

        $this->question->ask($this->input, $this->output, $query)->willReturn($confirm);

        $this->helpers->get('question')->willReturn($this->question);

        $this->setHelperSet($this->helpers);
    }
}
