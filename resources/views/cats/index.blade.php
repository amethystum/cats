@extends('master')

@section('header')
@if(isset($breed))
    {!! link_to('/', 'Back to the overview') !!}
@endif
  <h2>
  	My Cats!
    All @if(isset($breed)) {!! $breed->name !!} @endif Cats
    <a href="{!! url('cats/create') !!}" class="btn btn-primary pull-right">Add a new cat
    </a>
  </h2>
@stop
@section('content')
	<div>a lot of cats</div>
    @foreach($cats as $cat)
    <div class="cat">
      <a href="{!! url('cats/'.$cat->id) !!}">
        <strong>{!! $cat->name !!}</strong> - {!! $cat->breed->name !!}
      </a>
    </div>
  @endforeach
@stop
