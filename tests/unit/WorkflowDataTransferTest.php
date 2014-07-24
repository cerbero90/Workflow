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
    	$wf = new Workflow(['name' => 'foo']);

    	$this->assertEquals('Foo', $wf->name);
    }

    /**
     * @testdox	Retrieve the folder.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveTheFolder()
    {
    	$wf = new Workflow(['folder' => 'foo']);

    	$this->assertEquals('foo', $wf->folder);
    }

    /**
     * @testdox	Retrieve the path.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveThePath()
    {
    	$wf = new Workflow(['name' => 'foo', 'folder' => 'workflows']);

    	$expected = app_path() . '/workflows/Foo';

    	$this->assertEquals($expected, $wf->path);
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

    /**
     * @testdox	Retrieve the path with the folder option set to null.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testRetrieveThePathWithTheFolderOptionSetToNull()
    {
    	$wf = new Workflow(['name' => 'foo', 'folder' => null]);

    	$expected = app_path() . '/Foo';

    	$this->assertEquals($expected, $wf->path);
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
    public function testRetrieveTheNamespaceWithTheNamespaceAndFolderOptionsSetToNull()
    {
    	$wf = new Workflow(['namespace' => null, 'name' => 'bar', 'folder' => null]);

    	$this->assertEquals('Bar', $wf->namespace);
    }

    /**
     * @testdox	Set the method to trigger the workflow.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetTheMethodToTriggerTheWorkflow()
    {
    	$wf = new Workflow([]);

    	$workflow = $wf->setMethod('foo');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertEquals('foo', $wf->method);
    }

    /**
     * @testdox	Set the decorators.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetTheDecorators()
    {
    	$wf = new Workflow([]);

    	$workflow = $wf->setDecorators('foo bar');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertSame(['Foo', 'Bar'], $wf->decorators);
    }

    /**
     * @testdox	Set decorators to empty array if not set.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function testSetDecoratorsToEmptyArrayIfNotSet()
    {
    	$wf = new Workflow([]);

    	$workflow = $wf->setDecorators('');

        $this->assertInstanceOf('Cerbero\Workflow\WorkflowDataTransfer', $workflow);

    	$this->assertSame([], $wf->decorators);
    }

    }

}