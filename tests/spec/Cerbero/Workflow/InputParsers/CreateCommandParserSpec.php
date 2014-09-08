<?php

namespace spec\Cerbero\Workflow\InputParsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateCommandParserSpec extends ObjectBehavior
{

    /**
     * @author    Andrea Marco Sartori
     * @var       array    $input    Command input.
     */
    protected $input = ['name' => 'foo', 'namespace' => 'Bar', 'path' => 'baz', 'decorators' => 'foo, bar', 'method' => 'run', 'author' => 'john doe'];

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\InputParsers\CreateCommandParser');
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
     * @testdox	It parses the namespace.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_namespace()
    {
    	$expected = ['namespace' => 'Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a composite namespace.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_composite_namespace()
    {
        $this->input['namespace'] = 'Foo\Bar';

    	$expected = ['namespace' => 'Foo\Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with slashes.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_slashes()
    {
        $this->input['namespace'] = 'Foo/Bar';

    	$expected = ['namespace' => 'Foo\Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with slashes and backslashes.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_slashes_and_backslashes()
    {
        $this->input['namespace'] = 'Foo/Bar\Baz';

    	$expected = ['namespace' => 'Foo\Bar\Baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses an empty namespace.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_an_empty_namespace()
    {
        $this->input['namespace'] = '';

    	$expected = ['namespace' => ''];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with a trailing slash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_a_trailing_slash()
    {
        $this->input['namespace'] = 'Bar/';

    	$expected = ['namespace' => 'Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with a trailing backslash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_a_trailing_backslash()
    {
        $this->input['namespace'] = 'Bar\\';

    	$expected = ['namespace' => 'Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with a leading slash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_a_leading_slash()
    {
        $this->input['namespace'] = '/Bar';

    	$expected = ['namespace' => '\Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with a leading backslash.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_a_leading_backslash()
    {
        $this->input['namespace'] = '\Bar';

    	$expected = ['namespace' => '\Bar'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with lower case characters.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_namespace_with_lower_case_characters()
    {
        $this->input['namespace'] = 'foo\bar\baz';

    	$expected = ['namespace' => 'Foo\Bar\Baz'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a namespace with mixed case characters.
     *
     * @author	Andrea Marco Sartori
     * @return	void
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
     * @testdox	It parses the decorators.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_decorators()
    {
    	$expected = ['decorators' => ['Foo', 'Bar']];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses decorators with funky characters.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_decorators_with_funky_characters()
    {
    	$this->input['decorators'] = 'foo_v9 | _bar^';

    	$expected = ['decorators' => ['Foo_v9', '_bar']];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the method.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_method()
    {
    	$expected = ['method' => 'run'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses a method with trailing parenthesis.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_a_method_with_trailing_parenthesis()
    {
    	$this->input['method'] = 'run()';

    	$expected = ['method' => 'run'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the lower case name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_lower_case_name()
    {
    	$expected = ['lowername' => 'foo'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the lower case name when it is capitalized.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_lower_case_name_when_it_is_capitalized()
    {
    	$this->input['name'] = 'Foo';

    	$expected = ['lowername' => 'foo'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the lower case name when it is all upper case.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_lower_case_name_when_it_is_all_upper_case()
    {
    	$this->input['name'] = 'FOO';

    	$expected = ['lowername' => 'fOO'];

    	$this->parse($this->input)->shouldContainPair($expected);
    }

    /**
     * @testdox	It parses the author.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_parses_the_author()
    {
    	$expected = ['author' => 'john doe'];

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
