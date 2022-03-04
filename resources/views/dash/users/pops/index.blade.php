@extends('layouts.dash.app')
@section('page-title', 'Proof of Payments')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Proof of Payments</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <small>Once you proof of payment is accepted, the amount paid would reflect in your wallet</small>
          <div class="table-responsive my-3">
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>preview</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($proofs as $file)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      <a href="{{\Storage::url($file->path) }}" title="{{$file->name}}"><img src="{{\Storage::url($file->path) }}" class="img" style="width: 100px; hieght: 100px;"/></a>
                    </td>
                    <td>
                      <span class="badge d-block badge-{{ ($file->status === 'pending') ? 'warning' : ($file->status === 'accepted' ? 'success' : 'danger')}}">{{  $file->status }}</span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
