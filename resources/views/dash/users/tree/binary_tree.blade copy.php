@extends('layouts.dash.app')
@section('page-title', 'Binary Tree')
@section('extra-css')
<style>
    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover,
    .tree li a:hover+ul li a {
        background: #c8e4f8;
        color: #000;
        border: 1px solid #94a0b4;
    }

    /*Connector styles on hover*/
    .tree li a:hover+ul li::after,
    .tree li a:hover+ul li::before,
    .tree li a:hover+ul::before,
    .tree li a:hover+ul ul::before {
        border-color: #94a0b4;
    }

    .indicator {
        position: relative;
        padding-bottom: 25px;
    }

    .indicator:before,
    .indicator:after {
        content: '';
        position: absolute;
        background: #f00;
        height: 3px;
        width: 20%;
        bottom: -20%;
    }

    .indicator:before {
        left: 30.75%;
        transform: rotate(-20deg);
    }

    .indicator:after {
        right: 30.75%;
        transform: rotate(20deg);
    }

    tr:first-child .indicator:before,
    tr:first-child .indicator:after {
        bottom: -30%;
    }

    tr:first-child .indicator:before {
        left: 30.4%;
        transform: rotate(-15deg);
    }

    tr:first-child .indicator:after {
        right: 30.4%;
        transform: rotate(15deg);
    }

    tr:last-child .indicator {
        padding: 0;
    }

    tr:last-child .indicator:before,
    tr:last-child .indicator:after {
        display: none;
    }
    .tree{
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .tree-image{
        width: 40px;
    }
    
</style>
@endsection
@section('active')
<li class="breadcrumb-item active" aria-current="page">{{ $user->username }}'s tree</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Binary Tree</h4>

            </div>
            <div class="tree">
                <table border="0" width="100%" align="center" style="border-collapse: collapse" class="responsive">
                    <tbody>
                        {{-- Level 0 --}}
                       
                        <tr>
                            <td valign="top" height="45" colspan="64" align="center">
                                <img border="0" class="rounded-circle tree-image"
                                    @if($user->avatar)
                                        src="{{ asset($user->avatar)}}"
                                    @else
                                        src="{{ asset('site/assets/images/avatars/d2.png') }}"
                                    @endif
                                >
                                <p class="indicator">{{ $user->username }}</p>
                            </td>
                        </tr>
                        {{-- level 1 --}}
                        @if($level > 0)
                        <tr>
                            <td valign="top" align="center" width="400" height="45" colspan="32">
                                {{ $matrix->where('position', 1) }}
                                @foreach(json_decode($matrix->where('position', 1) as $user))
                                <img class="rounded-circle tree-image" border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-filled-128x128.png">
                                    
                                    <div class="icon-wrapper" data-bs-toggle="tooltip" title="Edit Client">
                                        <a href="#edit"><i class="fas fa-edit text-mute"></i></a>  
                                    </div>


                                    <br>
                                <p class="indicator">BG00000000<br>1a</p>
                                @endif
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="32">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                        </tr>
                        @endif
                        {{-- level 2 --}}
                        @if($level > 1)
                        <tr>
                            <td valign="top" align="center" width="200" height="40" colspan="16">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1a1</p>
                            </td>
                            <td valign="top" width="200" align="center" height="40" colspan="16">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-128x128.png"><br>
                                <p class="indicator">1a2OPEN</p>
                            </td>
                            <td valign="top" width="200" align="center" height="40" colspan="16">
                                <img class="rounded-circle tree-image" border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-128x128.png"><br>
                                <p class="indicator">1b1</p>
                            </td>
                            <td valign="top" width="200" height="40" align="center" colspan="16">
                                <img class="rounded-circle tree-image" border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b2</p>
                            </td>
                        </tr>
                        @endif
                        {{-- level 3 --}}
                        @if($level > 2)
                        <tr>
                            <td valign="top" align="center" width="400" height="45" colspan="8">
                                <img class="rounded-circle tree-image" border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1a</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="8">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                        </tr>
                        @endif
                        {{-- level 4 --}}
                        @if($level > 3)
                        <tr>
                            <td valign="top" align="center" width="400" height="45" colspan="4">
                                <img class="rounded-circle tree-image" border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1a</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="4">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                           
                        </tr>
                        @endif
                        {{-- level 5 --}}
                        @if($level > 5)
                        <tr>
                            <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                             <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                            <td valign="top" width="400" align="center" height="45" colspan="2">
                                <img class="rounded-circle tree-image"  border="0"
                                    src="https://freeiconshop.com/wp-content/uploads/edd/person-girl-outline-filled-128x128.png"><br>
                                <p class="indicator">BG00000000<br>1b</p>
                            </td>
                        </tr>
                        @endif
                        {{-- level 6 --}}
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
