@extends('layouts.with-sidebar')

@section('pageName', 'js-user-page')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop



@section('content')
<div class="container">
    <div id="user-panel" class="panel panel--default">

        <input type="hidden" name="user-id" id="user-id" value="{{ $player->id }}">

        <ul class="tabs">
            <li class="tab tab--active">
                <a href="#tab1">Details</a>
            </li>
           
            <div class="tabs__indicator"></div>
        </ul>

        @if (count($errors) > 0)
            <div class="alert alert--danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="tab1" class="panel">
            <div>
                <div class="user__personal-details panel__divider flex flex--space-between flex--bottom">
                    <h2 class="panel__title panel__title--small margin--bottom-none flex__item--1">Personal Details</h2>
                    <div id="user-actions-grp" class="user__button-grp button-group">
                        <a id="edit-profile-btn" class="btn btn--primary btn--md"><i class="icon icon--edit"></i> Edit</a>
                        <form method="POST" class="form--inline" action="{{ url('/players', $player->id) }}">
                            {{ method_field('DELETE') }}
                            <button id="delete-profile-btn" class="btn btn--outline btn--md" type="submit"><i class="icon icon--delete"></i> Delete</button>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                    <div id="content-actions-grp" class="user__button-grp button-group hidden">
                        <a id="save-changes-btn" class="btn btn--primary btn--md"><i class="icon icon--save"></i> Save</a>
                        <a id="cancel-changes-btn" class="btn btn--outline btn--md"><i class="icon icon--cancel"></i> Cancel</a>
                    </div>
                </div>
                <div>
                    <h4 class="user__label">Name</h4>
                    <div id="first_name-editor" class="user__input">{{ $player->first_name }}</div>
                    <h4 class="user__label">jurcy number</h4>
                    <div id="jsy_number-editor" class="user__input">{{ $player->jsy_number }}</div>
                    <h4 class="user__label">Country</h4>
                    <div id="country-editor" class="user__input">{{ $player->country }}</div>
                    <h4 class="user__label">Total run</h4>
                    <div id="run-editor" class="user__input">{{ $player->run }}</div>
                </div>
            </div>
            
            
        </div><!-- end #tab1 -->

       
    </div>
</div>
@stop