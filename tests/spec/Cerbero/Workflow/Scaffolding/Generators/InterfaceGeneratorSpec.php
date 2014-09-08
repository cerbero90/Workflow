<?php

namespace spec\Cerbero\Workflow\Scaffolding\Generators;

require_once __DIR__ . '/AbstractGeneratorBehavior.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InterfaceGeneratorSpec extends AbstractGeneratorBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Generators\InterfaceGenerator');
    }

    /**
     * @testdox	It generates the workflow interface.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_generates_the_workflow_interface()
    {
    	$this->assertFileDoesNotExist('Name/NameInterface.php');

    	$this->assertFolderWillBeCreated('Name');

    	$this->assertTemplateContentIsPutInFile('Name/NameInterface.php', 'interface_content', 'interface');

    	$this->generate($this->data)->shouldReturn(true);
    }

    /**
     * @testdox	It returns false if the interface creation fails.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_false_if_the_interface_creation_fails()
    {
    	$this->assertFileDoesNotExist('Name/NameInterface.php');

    	$this->assertFolderWillBeCreated('Name');

    	$this->assertTemplateContentIsNotPutInFile('Name/NameInterface.php', 'interface_content', 'interface');

    	$this->generate($this->data)->shouldReturn(false);
    }
}
