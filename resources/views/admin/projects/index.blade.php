@extends('layouts.app')

@section('content')

    @foreach($project as $element)
   
    <a href="{{ route('admin.projects.show', $element) }}">{{ $element['title'] }}</a>
    <img class="" style=" width : 150px " src="{{$element->img}}" alt="">


    @endforeach

@endsection