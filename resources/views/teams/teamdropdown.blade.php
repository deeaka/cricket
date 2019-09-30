@if (isset($teams))
                            @foreach ($teams as $team)
                            <option value="{{$team->team_id}}">{{$team->name}}</option>
                            @endforeach
@endif