<?php namespace spec\Cerbero\Workflow\Scaffolding\Generators;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Workflow\Scaffolding\TemplateEngines\TemplateEngineInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Describe the behavior of the abstract generator.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractGeneratorBehavior extends ObjectBehavior
{

    /**
     * @author    Andrea Marco Sartori
     * @var       array    $data    Template context.
     */
    protected $data = array('path' => 'foo/bar', 'name' => 'Name', 'namespace' => 'NS', 'decorators' => ['Foo', 'Bar']);

    /**
     * @author	Andrea Marco Sartori
     * @var		Double	$template	TemplateEngineInterface mock.
     */
    protected $template;

    /**
     * @author	Andrea Marco Sartori
     * @var		Double	$file	Filesystem mock.
     */
    protected $file;


	function let(TemplateEngineInterface $template, Filesystem $file)
	{
		$this->beConstructedWith($template, $file);

		$this->template = $template;

		$this->file = $file;
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Generators\AbstractGenerator');
    }

    /**
     * Assert the given file exists.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$file
     * @return	void
     */
    protected function assertFileExists($file)
    {
    	$this->file->exists("foo/bar/{$file}")->willReturn(true);
    }

    /**
     * Assert the given file does not exist.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$file
     * @return	void
     */
    protected function assertFileDoesNotExist($file)
    {
    	$this->file->exists("foo/bar/{$file}")->willReturn(false);
    }

    /**
     * Assert the given file contains the given content.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$content
     * @param	sring	$file
     * @return	void
     */
    protected function assertFileContains($content, $file)
    {
    	$this->file->get("foo/bar/{$file}")->willReturn($content);
    }

    /**
     * Assert the given folder will be created.
     *
     * @author	Andrea Marco Sartori
     * @param	sring|null	$folder
     * @return	void
     */
    protected function assertFolderWillBeCreated($folder = null)
    {
		$this->file->exists("foo/bar/{$folder}")->willReturn(false);

        $this->file->makeDirectory("foo/bar/{$folder}", 0755, true)->willReturn(true);
    }

    /**
     * Assert the given folder will not be created.
     *
     * @author	Andrea Marco Sartori
     * @param	sring|null	$folder
     * @return	void
     */
    protected function assertFolderWillNotBeCreated($folder = null)
    {
		$this->file->exists("foo/bar/{$folder}")->willReturn(true);
    }

    /**
     * Assert the given template content is put in the given file.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$file
     * @param	sring	$content
     * @param	sring	$template
     * @return	void
     */
    protected function assertTemplateContentIsPutInFile($file, $content, $template)
    {
        $this->template->render($template, $this->data)->willReturn($content);

        $this->file->put("foo/bar/{$file}", $content)->willReturn(strlen($content));
    }

    /**
     * Assert the given template content is appended to the given file.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$file
     * @param	sring	$content
     * @param	sring	$template
     * @return	void
     */
    protected function assertTemplateContentIsAppendedToFile($file, $content, $template)
    {
        $this->template->render($template, $this->data)->willReturn($content);

        $this->file->append("foo/bar/{$file}", $content)->willReturn(strlen($content));
    }

    /**
     * Assert the given template content is not put in the given file.
     *
     * @author	Andrea Marco Sartori
     * @param	sring	$file
     * @param	sring	$content
     * @param	sring	$template
     * @return	void
     */
    protected function assertTemplateContentIsNotPutInFile($file, $content, $template)
    {
        $this->template->render($template, $this->data)->willReturn($content);

        $this->file->put("foo/bar/{$file}", $content)->willReturn(false);
    }

}