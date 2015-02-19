<?php

namespace spec\Cerbero\Workflow\Inflectors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Workflow\Wrappers\NamespaceDetectorInterface;

class InflectorSpec extends ObjectBehavior
{
	function let(NamespaceDetectorInterface $detector)
	{
		$this->beConstructedWith($detector);

		$detector->detect()->willReturn('App');
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Workflow\Inflectors\Inflector');
        $this->shouldHaveType('Cerbero\Workflow\Inflectors\InflectorInterface');
    }

    /**
     * @testdox	It returns itself after setting the word to inflect.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_itself_after_setting_the_word_to_inflect()
    {
    	$this->of('foo')->shouldReturn($this);
    }

    /**
     * @testdox	It inflects the request.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_inflects_the_request()
    {
    	$expected = 'App\Http\Requests\RegisterUserRequest';

    	$this->of('registerUser')->getRequest()->shouldReturn($expected);
    }

    /**
     * @testdox	It inflects the command.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_inflects_the_command()
    {
    	$expected = 'App\Commands\RegisterUserCommand';

    	$this->of('registerUser')->getCommand()->shouldReturn($expected);
    }
}
