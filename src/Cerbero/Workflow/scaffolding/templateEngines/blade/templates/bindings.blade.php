// Bind the [{{$name}}] workflow
App::bind('{{$namespace}}\{{$name}}Interface', function($app)
{
	return new @include('bind', ['i' => 0]);
});

