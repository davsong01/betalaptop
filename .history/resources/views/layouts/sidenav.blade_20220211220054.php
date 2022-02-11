<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('account') }}" aria-expanded="false"><i class="me-3 far fa-clock fa-fw"
        aria-hidden="true"></i><span class="hide-menu">Dashboard</span>
    </a>
</li>
@if(auth()->user()->role == 'admin')
@endif
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('profile') }}" aria-expanded="false">
        <i class="me-3 fa fa-user" aria-hidden="true"></i><span
            class="hide-menu">Profile</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="table-basic.html" aria-expanded="false"><i class="me-3 fa fa-table"
            aria-hidden="true"></i><span class="hide-menu">Table</span></a></li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="icon-fontawesome.html" aria-expanded="false"><i class="me-3 fa fa-font"
            aria-hidden="true"></i><span class="hide-menu">Icon</span></a></li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="map-google.html" aria-expanded="false"><i class="me-3 fa fa-globe"
            aria-hidden="true"></i><span class="hide-menu">Google Map</span></a></li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="blank.html" aria-expanded="false"><i class="me-3 fa fa-columns"
            aria-hidden="true"></i><span class="hide-menu">Blank</span></a></li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="404.html" aria-expanded="false"><i class="me-3 fa fa-info-circle"
            aria-hidden="true"></i><span class="hide-menu">Error 404</span></a></li>

<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}" aria-expanded="false"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="me-3 fa fa-sign-out" aria-hidden="true"></i><span class="hide-menu">Logout</span></a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</li>