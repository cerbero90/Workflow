<?php

namespace spec\Cerbero\Workflow\Scaffolding\Generators;

require_once __DIR__ . '/AbstractGeneratorBehavior.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MainClassGeneratorSpec extends AbstractGeneratorBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Generators\MainClassGenerator');
    }

    /**
     * @testdox	It generates the workflow main class.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_generates_the_workflow_main_class()
    {
    	$this->assertFileDoesNotExist('Name/Name.php');

    	$this->assertFolderWillBeCreated('Name');

    	$this->assertTemplateContentIsPutInFile('Name/Name.php', 'main_content', 'main');

    	$this->generate($this->data)->shouldReturn(true);
    }

    /**
     * @testdox	It returns false if the main class creation fails.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_false_if_the_main_class_creation_fails()
    {
    	$this->assertFileDoesNotExist('Name/Name.php');

    	$this->assertFolderWillBeCreated('Name');

    	$this->assertTemplateContentIsNotPutInFile('Name/Name.php', 'main_content', 'main');

    	$this->generate($this->data)->shouldReturn(false);
    }
}
