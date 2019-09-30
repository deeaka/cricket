@extends('layouts.with-sidebar')

@section('pageName', 'js-users-page')

@section('content')
<div class="container">
    <div id="users-panel" class="panel panel--default">
        <div class="users__header flex flex--space-between flex--middle">
            <div>@include('svg.user'){{ count($matchs) }} Matches</div>
            @can('store', Auth::user())
                <ul id="user-admin-actions" class="list list--inline button-group button-group--right">
                    <li>
                        <form method="GET" action="{{ url('/match/create') }}">
                             @if (isset($teamId))
                            <input type="hidden"  mame="team_id" value ="{{$teamId}}">
                             @endif
                            <button id="create-user-btn" class="btn btn--primary" type="submit"><i class="icon icon--create-user"></i> Add Match</button>
                        </form>
                    </li>
                </ul>
            @endcan
        </div>

        <div class="padding--bottom-lg">
            <table id="users-list" class="table table--bordered table--hover table--responsive">
                <thead>
                    <tr>
                        
                        <th>&nbsp;</th>
                        <th>First Teams</th>                        
                        <th>Second Teams</th>  
                        <th>Winner Teams</th>  
                    </tr>
                </thead>
                <tbody>
                @foreach ($matchs as $mch)
                    <tr>
                        
                        <td class="users__status-icon">
                            @include('svg.star')
                        </td>
                        <td data-th="Company">{{ $mch->firstTeam->name }}</td>                        
                        <td data-th="Company">{{ $mch->secondTeam->name }}</td>
                        <td data-th="Company">{{ $mch->winnerTeam->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop