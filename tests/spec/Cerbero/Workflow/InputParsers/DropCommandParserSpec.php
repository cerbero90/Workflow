<?php

namespace spec\Cerbero\Workflow\InputParsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DropCommandParserSpec extends ObjectBehavior
{

    /**
     * @author    Andrea Marco Sartori
     * @var       array    $input    Command input.
     */
    protected $input = ['name' => 'foo', 'namespace' => 'Bar', 'path' => 'baz'];

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\InputParsers\DropCommandParser');
    }

    /**
     * @testdox	It parses the name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_name()
    {
    	$expected = ['name' => 'Foo'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses the namespace.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_the_namespace()
    {
        $expected = ['namespace' => 'Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a composite namespace.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_composite_namespace()
    {
        $this->input['namespace'] = 'Foo\Bar';

        $expected = ['namespace' => 'Foo\Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with slashes.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_slashes()
    {
        $this->input['namespace'] = 'Foo/Bar';

        $expected = ['namespace' => 'Foo\Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with slashes and backslashes.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_slashes_and_backslashes()
    {
        $this->input['namespace'] = 'Foo/Bar\Baz';

        $expected = ['namespace' => 'Foo\Bar\Baz'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses an empty namespace.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_an_empty_namespace()
    {
        $this->input['namespace'] = '';

        $expected = ['namespace' => ''];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with a trailing slash.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_a_trailing_slash()
    {
        $this->input['namespace'] = 'Bar/';

        $expected = ['namespace' => 'Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with a trailing backslash.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_a_trailing_backslash()
    {
        $this->input['namespace'] = 'Bar\\';

        $expected = ['namespace' => 'Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with a leading slash.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_a_leading_slash()
    {
        $this->input['namespace'] = '/Bar';

        $expected = ['namespace' => '\Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with a leading backslash.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_a_leading_backslash()
    {
        $this->input['namespace'] = '\Bar';

        $expected = ['namespace' => '\Bar'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with lower case characters.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_lower_case_characters()
    {
        $this->input['namespace'] = 'foo\bar\baz';

        $expected = ['namespace' => 'Foo\Bar\Baz'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox It parses a namespace with mixed case characters.
     *
     * @author  Andrea Marco Sartori
     * @return  void
     */
    public function it_parses_a_namespace_with_mixed_case_characters()
    {
        $this->input['namespace'] = 'foo\barBaz';

        $expected = ['namespace' => 'Foo\BarBaz'];

        $this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the path.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_path()
    {
    	$expected = ['path' => 'baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a path with backslashes.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_path_with_backslashes()
    {
        $this->input['path'] = 'foo\bar\baz';

    	$expected = ['path' => 'foo/bar/baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a path with a trailing slash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_path_with_a_trailing_slash()
    {
        $this->input['path'] = 'foo/bar/baz/';

    	$expected = ['path' => 'foo/bar/baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a path with a trailing backslash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_path_with_a_trailing_backslash()
    {
        $this->input['path'] = 'foo\bar\baz\\';

    	$expected = ['path' => 'foo/bar/baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * Retrieve custom matchers.
     *
     * @author	Andrea Marco Sartori
     * @return	array
     */
    public function getMatchers()
    {
    	return array
    	(
    		'containPair' => function($subject, $pair)
    		{
    			list($key, $value) = each($pair);

    			return $subject[$key] === $value;
    		}
    	);
    }
}
