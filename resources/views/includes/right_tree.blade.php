@if($user != 0)
@php
    $downline = \App\User::downline($user);
@endphp
 <span class="details">
    <a href="{{ route('binarytree', $downline->id) }}">
    <img border="0" class="rounded-circle tree-image"
        @if($downline->avatar)
            src="{{ asset($downline->avatar)}}"
        @else
            src="{{ asset('site/assets/images/avatars/d2.png') }}"
        @endif
    >
    </a>
    <br>
    <p class="indicator">{{ $downline->username }}</p>
 </span>
@else
 <span class="details">
    <img class="rounded-circle tree-image"  border="0" src="https://freeiconshop.com/wp-content/uploads/edd/person-outline-128x128.png">
    <br>
    @include('includes.addUserModal')
    <p class="indicator" style="color:red">
    {{-- <a href="#" data-bs-toggle="tooltip" title="Fill position" data-toggle="modal" data-target="#modal-{{ $mat->id.'r'.$value}}"><i class="fas fa-edit text-mute"></i></a>  --}}
    Empty
    </p>
 </span>
@endif
    
