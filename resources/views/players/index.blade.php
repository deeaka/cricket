@extends('layouts.with-sidebar')

@section('pageName', 'js-users-page')

@section('content')
<div class="container">
    <div id="users-panel" class="panel panel--default">
        <div class="users__header flex flex--space-between flex--middle">
            <div>@include('svg.user'){{ count($players) }} Players</div>
            @can('store', Auth::user())
                <ul id="user-admin-actions" class="list list--inline button-group button-group--right">
                    <li>
                        <form method="GET" action="{{ url('/players/create') }}">
                             @if (isset($teamId))
                            <input type="hidden"  mame="team_id" value ="{{$teamId}}">
                             @endif
                            <button id="create-user-btn" class="btn btn--primary" type="submit"><i class="icon icon--create-user"></i> Add Player</button>
                        </form>
                    </li>
                </ul>
            @endcan
        </div>

        <div class="padding--bottom-lg">
            <table id="users-list" class="table table--bordered table--hover table--responsive">
                <thead>
                    <tr>
                        <th class="text--center"><input type="checkbox" name="checkall" /></th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Teams</th>
                        <th>Matches</th>
                        <th>Runs</th>
                        <th>Highest Scores</th>
                        <th>Hundreds</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td class="users__checkbox"><input type="checkbox" /></td>
                        <td class="users__status-icon">
                            @include('svg.star')
                        </td>
                        <td class="users__avatar-container">
                            @if ($player->image_uri)
                            <a href="/player/{{ $player->id }}">
                                <img src="{{ $player->image_uri }}" alt="{{ $player->jsy_number }}" class="users__avatar" width="28" height="28">
                            </a>
                            @endif
                        </td>
                        <td data-th="Name"><a href="/players/{{ $player->id }}">{{ $player->first_name }}</a></td>
                        <td data-th="Company">{{ $player->country }}</td>
                        <td data-th="Company">{{ $player->team->name }}</td>
                        <td data-th="Email">{{$player->matches}}</td>
                        <td data-th="Email">{{$player->run}}</td>
                        <td data-th="Email">{{$player->highest_scores}}</td>
                        <td data-th="Email">{{$player->hundreds}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop