<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('account') }}" aria-expanded="false"><i class="me-3 fa fa-home"></i><span class="hide-menu">Dashboard</span>
    </a>
</li>
@if(auth()->user()->role == 1)
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('users.index') }}" aria-expanded="false">
        <i class="me-3 fa fa-users" aria-hidden="true"></i><span
            class="hide-menu">Manage Users</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('wallettransactions.index') }}" aria-expanded="false">
       <i class="me-3 fa fa-credit-card"></i><span
            class="hide-menu">Wallet Transactions</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('payments.index') }}" aria-expanded="false">
        <i class="me-3 fa fa-money" aria-hidden="true"></i><span
            class="hide-menu">Online Payments</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('transactions.index') }}" aria-expanded="false">
        <i class="me-3 fa fa-file-text" aria-hidden="true"></i><span
            class="hide-menu">Proof of Payments</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('settings.index') }}" aria-expanded="false">
        <i class="me-3 fa fa-cog" aria-hidden="true"></i><span
            class="hide-menu">Settings</span></a>
</li>
@endif
@if(auth()->user()->role == 2)

<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('transactions.index') }}" aria-expanded="false">
        <i class="me-3 fa fa-money" aria-hidden="true"></i><span
            class="hide-menu">Wallet</span></a>
</li>
@endif
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
        href="{{ route('profile') }}" aria-expanded="false">
        <i class="me-3 fa fa-user" aria-hidden="true"></i><span
            class="hide-menu">Profile</span></a>
</li>
<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}" aria-expanded="false"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="me-3 fa fa-sign-out" aria-hidden="true"></i><span class="hide-menu">Logout</span></a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</li>