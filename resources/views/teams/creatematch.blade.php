@extends('layouts.with-sidebar')

@section('pageName', 'js-create-user-page')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop



@section('content')
<div class="container">
    <div id="user-panel" class="panel panel--default">

        <h1>Create New Match</h1>

        @if (count($errors) > 0)
            <div class="alert alert--danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="create-user" class="panel">
            <form action="{{ url('/match') }}" method="POST">
                <input type="hidden" id="user-avatar" name="avatar" value="">

                <div>
                    <div class="panel__divider flex flex--space-between flex--bottom flex--wrap">
                        <h2 class="panel__title panel__title--small margin--bottom-none flex__item--1">Macth Details</h2>
                        <div id="content-actions-grp" class="button-group">
                            <button id="save-changes-btn" class="btn btn--primary btn--md" type="submit" name="save" value="save"><i class="icon icon--save"></i> Save</button>
                        </div>
                    </div>
                    <div>
                        <div class="form-group form-group--lg">
                            <label class="user__label" for="user-name">First Team Name</label>
                            <select name="first_team_num" id="team_num" class="form-control form-control--secondary">
                                <option value="">Please select</option>
                                 @include('teams.teamdropdown')
                             </select>                           
                        </div>
                        <div class="form-group form-group--lg">
                            <label class="user__label" for="user-name">Second Team</label>
                            <select name="second_team_num" id="team_num" class="form-control form-control--secondary">
                                <option value="">Please select</option>
                                 @include('teams.teamdropdown')
                             </select>                         
                        </div>
                        <div class="form-group form-group--lg">
                            <label class="user__label" for="user-name">Winner Name</label>
                            <input type="radio" name="winnerTeam" value="f">First Team
                            <input type="radio" name="winnerTeam" value="s">Second Team
                        </div>                                         
                    </div>
                </div>                                

                {!! csrf_field() !!}
            </form>
        </div><!-- end #create-user -->
    </div>
</div>
@stop