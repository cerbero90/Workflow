<{{'?'}}php namespace {{$namespace}}\Decorators;

use {{$namespace}}\{{$name}}Interface;

/**
 * Decorator of the {{$lowername}} workflow.
 *
@if($author)
 * @author	{{$author}}
@endif
 */
class {{$decorator}} implements {{$name}}Interface
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
		$this->{{$lowername}}->{{$method}}($data);
	}

}