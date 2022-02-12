@extends('layouts.dash.app')
@section('page-title', 'Settings')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection
@section('content')
<div class="row">
    <!-- Column -->
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('saveprofile')}}" class="form-horizontal form-material mx-2">
                   @csrf
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Company Name</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control ps-0 form-control-line" name="name" required value="{{ old('company_name') ?: $setting->company_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="official_email" class="col-md-12">Official Email</label>
                        <div class="col-md-12">
                            <input type="email" class="form-control ps-0 form-control-line" required name="official_email" id="official_email" value="{{ old('official_email') ?: $setting->official_email }}">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-12 mb-0">App Phone No</label>
                        <div class="col-md-12">
                            <input type="text" name="official_phone" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Message</label>
                        <div class="col-md-12">
                            <textarea rows="5" class="form-control ps-0 form-control-line"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Select Country</label>
                        <div class="col-sm-12 border-bottom">
                            <select class="form-select shadow-none border-0 ps-0 form-control-line">
                                <option>London</option>
                                <option>India</option>
                                <option>Usa</option>
                                <option>Canada</option>
                                <option>Thailand</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-success mx-auto mx-md-0 text-white">Update
                                Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection
