<section class="sidebar">
   
    <nav class="sidebar-nav">
        <ul class="sidebar-nav__links">
            <li>
                <a class="sidebar-nav__link" href="{{ url('/') }}">
                    @include('svg.home')Home
                </a>
            </li>
            <li>
                <a class="sidebar-nav__link" href="{{ url('/teams') }}">
                    @include('svg.team')Teams
                </a>
            </li>
            <li>
                <a class="sidebar-nav__link" href="{{ url('/players') }}">
                    @include('svg.users')Players
                </a>
            </li>
            <li>
                <a class="sidebar-nav__link" href="{{ url('/match') }}">
                    @include('svg.courses')Matched
                </a>
            </li>
            <li>
                <a class="sidebar-nav__link" href="{{ url('/logout') }}">
                    @include('svg.courses')Logout
                </a>
            </li>
            </ul>
    </nav>
</section>