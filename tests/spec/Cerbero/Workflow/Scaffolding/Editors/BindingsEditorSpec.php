<?php

namespace spec\Cerbero\Workflow\Scaffolding\Editors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Filesystem\Filesystem;

class BindingsEditorSpec extends ObjectBehavior
{
	function let(Filesystem $file)
	{
		$this->beConstructedWith($file);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Editors\BindingsEditor');
    }

    /**
     * @testdox	It removes an existing binding.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_removes_an_existing_binding($file)
    {
		$before = $this->getStub('bindings_before');

    	$file->get('foo/bar/bindings.php')->shouldBeCalled()->willReturn($before);

		$after = $this->getStub('bindings_after');

    	$file->put('foo/bar/bindings.php', $after)->shouldBeCalled()->willReturn(true);

    	$this->removeWorkflow('Foo', 'Workflows', 'foo/bar')->shouldReturn(true);
    }

    /**
     * @testdox	It removes an existing binding even if its comment has been deleted.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_removes_an_existing_binding_even_if_its_comment_has_been_deleted($file)
    {
		$before = $this->getStub('uncommented_bindings_before');

    	$file->get('foo/bar/bindings.php')->shouldBeCalled()->willReturn($before);

		$after = $this->getStub('uncommented_bindings_after');

    	$file->put('foo/bar/bindings.php', $after)->shouldBeCalled()->willReturn(true);

    	$this->removeWorkflow('Foo', 'Workflows', 'foo/bar')->shouldReturn(true);
    }

    /**
     * Retrieve the content of a stub.
     *
     * @author	Andrea Marco Sartori
     * @param	string	$file
     * @return	string
     */
    private function getStub($file)
    {
    	return file_get_contents(__DIR__ . "/stubs/{$file}.stub");
    }
}
