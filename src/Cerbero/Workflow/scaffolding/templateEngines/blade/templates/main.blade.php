<{{'?'}}php namespace {{$namespace}}\{{$name}};

/**
 * Main workflow class.
 *
@if($author)
 * @author	{{$author}}
@endif
 */
class {{$name}} implements {{$name}}Interface
{

	/**
	 * Trigger the workflow.
	 *
@if($author)
	 * @author	{{$author}}
@endif
	 * @param	$data
	 */
	public function {{$method}}($data = null)
	{
		//
	}

}