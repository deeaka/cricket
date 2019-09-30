@if (isset($additional_classes))
<div class="card {{ $additional_classes }}">
    @else
    <div class="card">
        @endif
        
                <a href="{{ url('/teams', $team->team_id.'/player') }}">
            
                @if (isset($team->logo_uri))
                <figure class="cad-figure">
                    <img src={{ $team->logo_uri }} />
                    <!-- <img src="http://placehold.it/400x175" /> -->
                </figure>
                @endif
                <h3 class="card-title">{{ $team->name }}</h3>
            </a>
    </div>