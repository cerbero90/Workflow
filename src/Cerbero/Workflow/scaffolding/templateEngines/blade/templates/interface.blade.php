<{{'?'}}php namespace {{$namespace}};

/**
 * Workflow interface.
 *
@if($author)
 * @author	{{$author}}
@endif
 */
interface {{$name}}Interface
{

	/**
	 * Trigger the {{$lowername}} workflow.
	 *
@if($author)
	 * @author	{{$author}}
@endif
	 * @param	$data
	 */
	public function {{$method}}($data = null);

}