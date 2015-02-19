<?php

namespace spec\Cerbero\Workflow\Repositories;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Workflow\Wrappers\YamlParserInterface;
use Illuminate\Filesystem\Filesystem;

class YamlPipelineRepositorySpec extends ObjectBehavior
{

    /**
     * @author    Andrea Marco Sartori
     * @var        array    $pipeline    Example of pipeline.
     */
    private $pipeline = array('RegisterUser' => ['Notifier', 'Logger']);

	function let(YamlParserInterface $parser, Filesystem $files)
	{
		$this->beConstructedWith($parser, $files, 'path/to/workflows');

		$parser->parse('path/to/workflows/workflows.yml')->shouldBeCalled()->willReturn($this->pipeline);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Repositories\YamlPipelineRepository');
        $this->shouldHaveType('Cerbero\Workflow\Repositories\PipelineRepositoryInterface');
    }

    /**
     * @testdox	It returns false when a pipeline does not exist.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_false_when_a_pipeline_does_not_exist()
    {
    	$this->exists('unknownPipeline')->shouldReturn(false);
    }

    /**
     * @testdox	It returns true when a pipeline exists.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_true_when_a_pipeline_exists()
    {
    	$this->exists('RegisterUser')->shouldReturn(true);
    }

    /**
     * @testdox	It returns the pipeline of a fiven workflow.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_the_pipeline_of_a_fiven_workflow()
    {
    	$expected = ['Notifier', 'Logger'];

    	$this->getPipesByPipeline('registerUser')->shouldReturn($expected);
    }

    /**
     * @testdox    It retrieves the source of the pipelines.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_the_source_of_the_pipelines()
    {
        $this->getSource()->shouldReturn('path/to/workflows/workflows.yml');
    }

    /**
     * @testdox    It creates the YAML file.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_creates_the_YAML_file($files)
    {
        $files->makeDirectory('path/to/workflows', 0755, true, true)->shouldBeCalled();

        $files->put('path/to/workflows/workflows.yml', '')->shouldBeCalled();

        $this->settle();
    }

    /**
     * @testdox    It stores the given pipeline and its pipes.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_stores_the_given_pipeline_and_its_pipes($parser, $files)
    {
        $parser->dump($this->pipeline)->willReturn('foo');

        $files->append('path/to/workflows/workflows.yml', 'foo')->shouldBeCalled();

        $this->store('RegisterUser', ['Notifier', 'Logger']);
    }

    /**
     * @testdox    It updates an existing pipeline by attaching and detaching pipes.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_updates_an_existing_pipeline_by_attaching_and_detaching_pipes($parser, $files)
    {
        $updated = ['RegisterUser' => ['Logger', 'Buzzer']];

        $parser->dump($updated)->willReturn('foo');

        $files->put('path/to/workflows/workflows.yml', 'foo')->shouldBeCalled();

        $this->update('RegisterUser', ['Buzzer'], ['Notifier']);
    }

    /**
     * @testdox    It does not attach if no attachments are specified.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_does_not_attach_if_no_attachments_are_specified($parser, $files)
    {
        $updated = ['RegisterUser' => ['Notifier']];

        $parser->dump($updated)->willReturn('foo');

        $files->put('path/to/workflows/workflows.yml', 'foo')->shouldBeCalled();

        $this->update('RegisterUser', [], ['Logger']);
    }

    /**
     * @testdox    It does not detach if no detachments are specified.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_does_not_detach_if_no_detachments_are_specified($parser, $files)
    {
        $updated = ['RegisterUser' => ['Notifier', 'Logger', 'Buzzer']];

        $parser->dump($updated)->willReturn('foo');

        $files->put('path/to/workflows/workflows.yml', 'foo')->shouldBeCalled();

        $this->update('RegisterUser', ['Buzzer'], []);
    }

    /**
     * @testdox    It destroys a pipeline.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_destroys_a_pipeline($parser, $files)
    {
        $parser->dump([])->willReturn('foo');

        $files->put('path/to/workflows/workflows.yml', 'foo')->shouldBeCalled();

        $this->destroy('RegisterUser');
    }
}
