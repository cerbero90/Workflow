<?php

use \Cerbero\Workflow\WorkflowDataTransfer as Workflow;

class WorkflowDataTransferTest extends \Codeception\TestCase\Test
{
   /**
    * @var \UnitTester
    */
    protected $tester;

    protected function _before()
    {
        $this->wf = new Workflow(['name' => 'foo']);
    }

    protected function _after()
    {
    }

    /**
     * @testdox	Retrieve the name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheName()
    {
    	$this->assertEquals('Foo', $this->wf->name);
    }

    /**
     * @testdox	Retrieve the folder.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheFolder()
    {
    	$this->assertEquals('workflows', $this->wf->folder);
    }

    /**
     * @testdox	Retrieve the path.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveThePath()
    {
    	$expected = app_path() . '/workflows/Foo';

    	$this->assertEquals($expected, $this->wf->path);
    }

    /**
     * @testdox	Retrieve the path with the folder option set.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveThePathWithTheFolderOptionSet()
    {
    	$wf = new Workflow(['name' => 'foo', 'folder' => 'bar']);

    	$expected = app_path() . '/bar/Foo';

    	$this->assertEquals($expected, $wf->path);
    }
    	$this->assertEquals($expected, $this->wf->path);
    }

    /**
     * @testdox	Retrieve the namespace.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheNamespace()
    {
    	$wf = new Workflow(['namespace' => 'Foo', 'name' => 'bar', 'folder' => 'baz']);

    	$this->assertEquals('Foo\Baz\Bar', $wf->namespace);
    }

    /**
     * @testdox	Retrieve the namespace with the namespace option set to null.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheNamespaceWithTheNamespaceOptionSetToNull()
    {
    	$wf = new Workflow(['namespace' => null, 'name' => 'bar', 'folder' => 'baz']);

    	$this->assertEquals('Baz\Bar', $wf->namespace);
    }

    /**
     * @testdox	Retrieve the namespace with the namespace option set to null.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheNamespaceWithTheNamespaceOptionSetToNull()
    {
    	$this->assertEquals('Workflows\Foo', $this->wf->namespace);
    }

    /**
     * @testdox	Set the method to trigger the workflow.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetTheMethodToTriggerTheWorkflow()
    {
    	$workflow = $this->wf->setMethod('foo');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertEquals('foo', $this->wf->method);
    }

    /**
     * @testdox	Set the decorators.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetTheDecorators()
    {
    	$workflow = $this->wf->setDecorators('foo bar');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertSame(['Foo', 'Bar'], $this->wf->decorators);
    }

    /**
     * @testdox	Set decorators to empty array if not set.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetDecoratorsToEmptyArrayIfNotSet()
    {
    	$workflow = $this->wf->setDecorators('');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertSame([], $this->wf->decorators);
    }

    /**
     * @testdox	Retrieve set properties.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveSetProperties()
    {
    	$this->wf->decorator = 'Foo';

    	$this->assertEquals('Foo', $this->wf->decorator);
    }

    /**
     * @testdox	Retrieve the lower cased name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheLowerCasedName()
    {
    	$this->assertEquals('foo', $this->wf->lowername);
    }

}