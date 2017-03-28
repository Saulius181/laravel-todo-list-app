@extends('layouts.main')
@section('content')
	<div class="large-12 columns">
		<h1>{{{ $list->name }}}</h1>
		@foreach ($items as $item)
			@if ($item->completed_on)
				<h4><del>{{{ $item->content }}}</del></h4>
			@else 
				<h4>{{{ $item->content }}}</h4>
			@endif
		@endforeach
		<p>{{ link_to_route('todos.index', 'back')}}</p>
	</div>
@stop