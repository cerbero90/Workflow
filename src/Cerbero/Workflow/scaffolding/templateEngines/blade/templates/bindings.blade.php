// Bind the [{{$name}}] workflow
App::bind('{{$namespace}}\{{$name}}\{{$name}}Interface', function($app)
{
	return new @include('bind', ['i' => 0]);
});

