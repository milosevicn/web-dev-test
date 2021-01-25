@extends('emails.layouts.layout')
@section('content')
<p>A new comment has been posted on your article ({{ $title }}) by {{$entity->name}}.</p>
@stop
