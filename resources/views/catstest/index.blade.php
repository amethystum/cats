@extends('master')

@section('header')
  <h2>
  	My Cats!
  </h2>
@stop
@section('content')
	<div>a lot of cats</div>
				{!! var_dump($teststr) !!}
        {!! $teststr !!}
@stop
