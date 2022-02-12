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
                        <label class="col-md-12 mb-0">App Name</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control ps-0 form-control-line" name="name" required value="{{ old('company_name') ?: $setting->company_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="official_email" class="col-md-12">App Email</label>
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
                        <label class="col-md-12 mb-0">App Bank</label>
                        <div class="col-md-12">
                            <input type="text" name="official_bank" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">App Account name</label>
                        <div class="col-md-12">
                            <input type="text" name="official_account_name" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">App Account number</label>
                        <div class="col-md-12">
                            <input type="text" name="official_account_number" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-6 mb-0">Change Logo</label> <br>
                        @component('components.logo')
                            @slot('width')
                            148px
                            @endslot
                            @slot('height')
                            20px
                            @endslot
                        @endcomponent
                        <br><br>
                        <div class="col-md-6">
                            <input type="file" name="logo" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-6 mb-0">Change Favicon</label> <br>
                        @component('components.logo')
                            @slot('width')
                            148px
                            @endslot
                            @slot('height')
                            20px
                            @endslot
                        @endcomponent
                        <br><br>
                        <div class="col-md-6">
                            <input type="file" name="logo" class="form-control ps-0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Select Currency</label>
                        <div class="col-sm-12 border-bottom">
                            <select class="form-select shadow-none border-0 ps-0 form-control-line">
                                <option value="">Select</option>
                                <option value="₦" {{ $setting->currency == '₦' ? 'selected' : '' }}>Naira</option>
                                <option value="$" {{ $setting->currency == '$' ? 'selected' : '' }}>Dollar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-success mx-auto mx-md-0 text-white">Update
                                Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection
