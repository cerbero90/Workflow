<{{'?'}}php namespace {{$namespace}}\Decorators;

use {{$namespace}}\{{$name}}Interface;
use Cerbero\Workflow\Validation\AbstractValidator;

/**
 * Decorator of the {{$lowername}} workflow.
 *
@if($author)
 * @author	{{$author}}
@endif
 */
class {{$decorator}} extends AbstractValidator implements {{$name}}Interface
{

	/**
@if($author)
	 * @author	{{$author}}
@endif
	 * @var 	{{$name}}Interface	${{$lowername}}	{{$name}} implementation.
	 */
	protected ${{$lowername}};
	
	/**
	 * Set the dependencies.
	 *
@if($author)
	 * @author	{{$author}}
@endif
	 * @param	{{$name}}Interface	${{$lowername}}
	 * @return	void
	 */
	public function __construct({{$name}}Interface ${{$lowername}})
	{
		$this->{{$lowername}} = ${{$lowername}};
	}

	/**
	 * Trigger the {{$lowername}} workflow.
	 *
@if($author)
	 * @author	{{$author}}
@endif
	 * @param	$data
	 */
	public function {{$method}}($data = null)
	{
		$this->validate($data);

		$this->{{$lowername}}->{{$method}}($data);
	}

	/**
	 * Retrieve the rules to apply.
	 *
@if($author)
	 * @author	{{$author}}
@endif
	 * @return	array
	 */
	protected function getRules()
	{
		return [];
	}

}