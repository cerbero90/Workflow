<?php

namespace spec\Cerbero\Workflow\Scaffolding\Generators;

require_once __DIR__ . '/AbstractGeneratorBehavior.php';


class BindingsGeneratorSpec extends AbstractGeneratorBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Generators\BindingsGenerator');
    }

    /**
     * @testdox    It creates the bindings file and then append the workflow to bind.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_creates_the_bindings_file_and_then_append_the_workflow_to_bind()
    {
        // first loop: create the bindings file and the folders
        $this->assertFileDoesNotExist('bindings.php');
        $this->assertFolderWillBeCreated();
        $this->assertTemplateContentIsPutInFile('bindings.php', '<?php ', 'empty');

        // second loop: append the bindings
        $this->assertFileExists('bindings.php');
        $this->assertFolderWillNotBeCreated();
        $this->assertTemplateContentIsAppendedToFile('bindings.php', 'NS\NameInterface', 'bindings');

        // exit from loop: the bindings file contains everything we need
        $this->assertFileContains('<?php NS\Name\NameInterface', 'bindings.php');

        $this->generate($this->data)->shouldReturn(true);
    }

    /**
     * @testdox    It skips the creation if the workflow has been already bound.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_skips_the_creation_if_the_workflow_has_been_already_bound()
    {
        $this->assertFileExists('bindings.php');

        $this->assertFileContains('NS\Name\NameInterface', 'bindings.php');

        $this->generate($this->data)->shouldReturn(true);
    }
}
