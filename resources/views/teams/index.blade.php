@extends('layouts.with-sidebar')




@section('content')
<div class="container">
    <div id="courses-panel" class="panel panel--secondary">
        <div class="courses__header flex flex--space-between margin--bottom">
            <div>@include('svg.courses_black'){{ count($teams) }} Teams</div>
            @can('store', App\Course::class)
                <ul id="course-admin-actions" class="list list--inline button-group button-group--right">
                    <li>
                        <form method="GET" action="{{ url('/teams/create') }}">
                            <button id="create-course-btn" class="btn btn--primary" type="submit"><i class="icon icon--create-course"></i> Create Team</button>
                        </form>
                    </li>
                </ul>
            @endcan
        </div>

        <div class="grid grid--width-1-1 grid--width-medium-1-2 grid--width-large-1-3 grid--small grid--match">
            @foreach ($teams as $team)
                <div>
                    @include('shared.team-grid-item')
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop