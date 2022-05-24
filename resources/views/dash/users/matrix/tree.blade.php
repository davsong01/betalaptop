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
              {{-- Level 1 --}}
              <tr>
                @foreach ($matrices as $matrix)
                  <td valign="top" align="center" width="400" height="45" colspan="32">
                    @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach
              </tr>
              @php
                if ($matrices->count()) {
                    $left = collect(optional($matrices[0])->children) ?? collect([]);
                    $right = collect(optional($matrices[1])->children) ?? collect([]);
                }
              @endphp
              {{-- Level 2 --}}
              @if ($left || $right)
                <tr>
                  {{-- Level 2 start left --}}
                  @foreach ($left as $matrix)
                    <td valign="top" align="center" width="200" height="40" colspan="16">
                      @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                    </td>
                  @endforeach

                  {{-- Level 2 end left --}}

                  {{-- Level 2 start right --}}
                  @foreach ($right as $matrix)
                    <td valign="top" width="200" align="center" height="40" colspan="16">
                      @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                    </td>
                  @endforeach
                  {{-- Level 2 end right --}}
                </tr>
              @endif
              {{-- // Level 2 --}}

              {{-- Level 3 --}}
              @php
                if ($left->count() || $right->count()) {
                    $level3LeftLeft = collect(optional($left[0])["children"]) ?? collect([]);
                    $level3LeftRight = collect(optional($left[1])["children"]) ?? collect([]);

                    $level3RightLeft = collect(optional($right[0])["children"]) ?? collect([]);
                    $level3RightRight = collect(optional($right[1])["children"]) ?? collect([]);
                }
              @endphp
              <tr>

                {{-- Level 3 start --}}
                @foreach ($level3LeftLeft as $matrix)
                  <td valign="top" align="center" width="400" height="45" colspan="8">
                      @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach

                @foreach ($level3LeftRight as $matrix)
                  <td valign="top" align="center" width="400" height="45" colspan="8">
                       @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach

                @foreach ($level3RightLeft as $matrix)
                  <td valign="top" align="center" width="400" height="45" colspan="8">
                      @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach

                @foreach ($level3RightRight as $matrix)
                  <td valign="top" align="center" width="400" height="45" colspan="8">
                       @if ($loop->index === 0)
                      @include('dash.users.matrix.tree.left')
                    @else
                      @include('dash.users.matrix.tree.right')
                    @endif
                  </td>
                @endforeach
              </tr>
              {{-- // Level 3 --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
