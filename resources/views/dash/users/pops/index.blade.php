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
          <div class="table-responsive my-3">
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>preview</th>
                  <th>Status</th>
                  <th>Action</th>
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
                      <span class="badge d-block badge-{{ ($file->state === 'pending') ? 'warning' : ($file->state === 'accepted' ? 'success' : 'danger')}}">{{  $file->state }}</span>
                    </td>
                    <td>
                      @if ($file->state === 'pending')
                         <form method="POST" action="{{route('transaction.delete.proofOfPayment', ['id' => $file->name])}}" class="inline-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-block btn-danger btn-sm" title="Cancel submitted file">Cancel</button>
                      </form>
                      @else
                        <button class="btn d-block btn-secondary btn-block" type="button">Not Available</button>
                      @endif
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
