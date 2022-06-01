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

              {{-- Level 2 mapping --}}
              @if ($matrices->filter(fn($item) => $item !== null)->isNotEmpty())
                @php $level3 = collect([]); @endphp
                <tr>
                  @foreach ($matrices as $mat)
                    @if ($mat)
                      @foreach (collect(optional($mat)['children']) as $matrix)
                        @php
                          $level3->push(optional($matrix)['children']);
                        @endphp
                        <td valign="top" align="center" width="200" height="40" colspan="16">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                      @endforeach
                    @else
                      @php
                        $level3->push([]);
                      @endphp
                      @php $matrix = null; @endphp
                      <td valign="top" align="center" width="200" height="40" colspan="16">
                        @include('dash.users.matrix.tree.left')
                      </td>
                      <td valign="top" align="center" width="200" height="40" colspan="16">
                        @include('dash.users.matrix.tree.right')
                      </td>
                    @endif
                  @endforeach
                </tr>
              @endif
              {{-- // Level 2 mapping --}}

              {{-- Level 3 mapping --}}
              @if ($level3->filter(fn($item) => $item !== null)->isNotEmpty())
                <tr>
                  @foreach ($level3 as $paired)
                    @if ($paired)
                      @foreach ($paired as $matrix)
                        <td valign="top" align="center" width="400" height="45" colspan="8">
                          @if ($loop->index === 0)
                            @include('dash.users.matrix.tree.left')
                          @else
                            @include('dash.users.matrix.tree.right')
                          @endif
                        </td>
                        <script>
                          console.log(@json($matrix));
                        </script>
                      @endforeach
                    @else
                      @php $matrix = null; @endphp
                      <td valign="top" align="center" width="200" height="40" colspan="8">
                        @include('dash.users.matrix.tree.left')
                      </td>
                      <td valign="top" align="center" width="200" height="40" colspan="8">
                        @include('dash.users.matrix.tree.right')
                      </td>
                    @endif
                  @endforeach
                </tr>
              @endif
              {{-- // Level 3 mapping --}}

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
