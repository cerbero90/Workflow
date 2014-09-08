@if($decorators)
{{$namespace}}\Decorators\{{$decorators[$i++]}}
<?php $tab = str_repeat("\t", $i) ?>
{{$tab}}(
	{{$tab}}new @if(count($decorators) === $i)
{{$namespace}}\{{$name}}\{{$name}}()@else
@include('bind')
@endif

{{$tab}})@else
{{$namespace}}\{{$name}}\{{$name}}()@endif