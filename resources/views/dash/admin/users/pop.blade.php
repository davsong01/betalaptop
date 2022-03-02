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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($files as $file)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      <a href="{{\Storage::url($file) }}" title="{{$file}}"><img src="{{\Storage::url($file) }}" class="img" style="width: 100px; hieght: 100px;"/></a></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-warning" title="Accept proof of payment">Accept</button>
                      <form method="POST" action="{{route('transaction.delete.proofOfPayment', ['id' => basename($file)])}}" class="inline-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Reject proof of payment">Reject</button>
                      </form>
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
