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

    .tree {
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }

    .tree-image {
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

              <tr>
                <td valign="top" height="45" colspan="64" align="center">
                  <img border="0" class="rounded-circle tree-image"
                    src="{{ asset($user->avatar ?? 'site/assets/images/avatars/d2.png') }}">
                  <p class="indicator">{{ $user->username }}</p>
                </td>
              </tr>
              {{-- Level 1 mapping --}}
               <tr>
                  @php
                $emptyUsers = [new \App\User, new \App\User];
                $level2 = [];
                @endphp
                @foreach ($matrices as $matrix)
                  @php
                    $level2 = array_merge($level2, Arr::flatten($matrix->mapping ?? $emptyUsers));
                  @endphp
                  <td valign="top" align="center" width="50%" height="45" colspan="32">
                    @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach
              </tr>
              {{-- // Level 1 mapping --}}

              {{-- // Level 2 mapping --}}
              @if (isset($level2) && collect($level2)->filter(fn($user) => $user->exists)->isNotEmpty())
                @php
                $level3 = [];
                @endphp
                <tr>
                  @foreach ($level2 as $matrix)
                       @php
                        $level3 = array_merge($level3, Arr::flatten($matrix->mapping ?? $emptyUsers));
                        @endphp
                      <td valign="top" align="center" width="25%" height="40" colspan="16">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                  @endforeach
                </tr>
              @endif
              {{-- // Level 2 mapping --}}

              {{-- // Level 3 mapping --}}
              @if (isset($level3) && collect($level3)->filter(fn($user) => $user->exists)->isNotEmpty())
                @php $level4 = [] @endphp
                <tr>
                  @foreach ($level3 as $matrix)
                    @php
                        $level4 = array_merge($level4, Arr::flatten($matrix->mapping ?? $emptyUsers));
                        @endphp
                      <td valign="top" align="center" width="400" height="45" colspan="8">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                  @endforeach
                </tr>
              @endif
              {{-- // Level 3 mapping --}}

              {{--  Level 4 mapping --}}
              @if (isset($level4) && collect($level4)->filter(fn($user) => $user->exists)->isNotEmpty())
              @php $level5 = [] @endphp
                <tr>
                  @foreach ($level4 as $matrix)
                   @php $level5 = array_merge($level5, Arr::flatten($matrix->mapping ?? $emptyUsers)); @endphp
                      <td valign="top" align="center" width="400" height="45" colspan="4">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                  @endforeach
                </tr>
              @endif
              {{-- // Level 4 mapping --}}

              {{--  Level 5 mapping --}}
              @if (isset($level5) && collect($level5)->filter(fn($user) => $user->exists)->isNotEmpty())
                <tr>
                  @foreach ($level5 as $matrix)
                      <td valign="top" align="center" width="400" height="45" colspan="2">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                  @endforeach
                </tr>
              @endif
              {{-- // Level 5 mapping --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
