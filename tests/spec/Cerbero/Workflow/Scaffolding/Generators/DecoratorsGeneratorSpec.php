<?php

namespace spec\Cerbero\Workflow\Scaffolding\Generators;

require_once __DIR__ . '/AbstractGeneratorBehavior.php';


class DecoratorsGeneratorSpec extends AbstractGeneratorBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Scaffolding\Generators\DecoratorsGenerator');
    }

    /**
     * @testdox	It generates all the provided decorators.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_generates_all_the_provided_decorators()
    {
    	// first loop: generate the Foo decorator
    	$this->data['decorator'] = 'Foo';
    	$this->assertFileDoesNotExist('Name/Decorators/Foo.php');
    	$this->assertFolderWillBeCreated('Name/Decorators');
    	$this->assertTemplateContentIsPutInFile('Name/Decorators/Foo.php', 'decorator_content', 'decorator');
       	$this->assertFileExists('Name/Decorators/Foo.php');

    	// second loop: generate the Bar decorator
    	$this->data['decorator'] = 'Bar';
       	$this->assertFileDoesNotExist('Name/Decorators/Bar.php');
    	$this->assertFolderWillNotBeCreated('Name/Decorators');
    	$this->assertTemplateContentIsPutInFile('Name/Decorators/Bar.php', 'decorator_content', 'decorator');
       	$this->assertFileExists('Name/Decorators/Bar.php');

    	$this->generate($this->data)->shouldReturn(true);
    }

    /**
     * @testdox	It can generate a validator.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_can_generate_a_validator()
    {
    	$this->data['decorators'] = ['Validator'];
    	$this->assertFileDoesNotExist('Name/Decorators/Validator.php');
    	$this->assertFolderWillBeCreated('Name/Decorators');
    	$this->assertTemplateContentIsPutInFile('Name/Decorators/Validator.php', 'validator_content', 'validator');
       	$this->assertFileExists('Name/Decorators/Validator.php');

    	$this->generate($this->data)->shouldReturn(true);
    }
}
