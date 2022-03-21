@extends('layouts.dash.app')
@section('page-title', 'Pending Emails')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Pending Emails</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <!-- column -->
          <div class="mb-10">
            <form action="{{route('retry.pending.mails')}}" method="POST">
              @csrf
              <button type="submit" class="btn btn-sm btn-success">Retry Pending Emails</button>
            </form>
          </div>
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Recipient</th>
                  <th>Subject</th>
                  <th>Content</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pending_emails as $email)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $email->name }}</td>
                    <td>{{ $email->recipient }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{!! $email->content !!}</td>
                    <td title="{{ $email->created_at }}">{{ $email->created_at->diffForHumans() }}</td>
                    <td>
                      <form action="{{route('retry.single.pending.mail', ['id' => $email->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Retry</button>
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
