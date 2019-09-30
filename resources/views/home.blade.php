@extends('layouts.with-sidebar')

@section('pageName', 'js-home-page')

@section('hero')
    @include('shared.hero', [
                            'hero_image' => 'img/bg/home.jpg',
                            'hero_title' => 'Welcome,',
                            'hero_subtitle' => Auth::user()->name
                            ])
@stop

@section('content')
<div class="container">
   
</div>
@endsection
