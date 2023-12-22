@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="dashboard_box mb-30">
            <h4 class="title mb-25">@lang('Personal Details ')</h4>
            <div class="dashboard_body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="register" action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('First Name')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" name="firstname"
                                                value="{{ $user->firstname }}" required>
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('Last Name')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" name="lastname"
                                                value="{{ $user->lastname }}" required>
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('E-mail Address')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                            <i class="fa-regular fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('Mobile Number')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" value="{{ $user->mobile }}" readonly>
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('Address')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" name="address"
                                                value="{{ @$user->address->address }}">
                                            <i class="fa-regular fa-address-book"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('State')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" name="state"
                                                value="{{ @$user->address->state }}">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('Zip Code')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control" name="zip"
                                                value="{{ @$user->address->zip }}">
                                            <i class="fa-solid fa-hashtag"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group profile mb-25">
                                        <label for="first_name1">@lang('Country')</label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control"
                                                value="{{ @$user->address->country }}" disabled>
                                            <i class="fa-solid fa-earth-americas"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Gender')<span class="text-danger">*</span>
                                        </label>
                                        <div class="single-input_">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="Male"
                                                    {{ @$user->address->gender == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ @$user->address->gender == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Non-binary"
                                                    {{ @$user->address->gender == 'Non-binary' ? 'selected' : '' }}>
                                                    Non-binary
                                                </option>
                                                <option value="Prefer not to say"
                                                    {{ @$user->address->gender == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer
                                                    not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Pet Ownership')<span class="text-danger">*</span>
                                        </label>
                                        <div class="single-input_">
                                            <select name="pet_ownership" id="pet_ownership" class="form-control">
                                                <option value="I own pets"
                                                    {{ @$user->address->pet_ownership == 'I own pets' ? 'selected' : '' }}>
                                                    I own
                                                    pets</option>
                                                <option value="I am comfortable with pets"
                                                    {{ @$user->address->pet_ownership == 'I am comfortable with pets' ? 'selected' : '' }}>
                                                    I am comfortable with pets</option>
                                                <option value="I prefer a pet-free environment"
                                                    {{ @$user->address->pet_ownership == 'I prefer a pet-free environment' ? 'selected' : '' }}>
                                                    I prefer a pet-free environment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Ethnicity')<span class="text-danger">*</span>
                                        </label>
                                        <div class="single-input_">
                                            <select name="ethnicity" id="ethnicity" class="form-control">
                                                <option value="Asian"
                                                    {{ @$user->address->ethnicity == 'Asian' ? 'selected' : '' }}>Asian
                                                </option>
                                                <option value="Black/African American"
                                                    {{ @$user->address->ethnicity == 'Black/African American' ? 'selected' : '' }}>
                                                    Black/African American</option>
                                                <option value="Hispanic/Latino"
                                                    {{ @$user->address->ethnicity == 'Hispanic/Latino' ? 'selected' : '' }}>
                                                    Hispanic/Latino</option>
                                                <option value="White/Caucasian"
                                                    {{ @$user->address->ethnicity == 'White/Caucasian' ? 'selected' : '' }}>
                                                    White/Caucasian</option>
                                                <option value="Other"
                                                    {{ @$user->address->ethnicity == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                                <option value="Prefer not to say"
                                                    {{ @$user->address->ethnicity == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Nationality')<span class="text-danger">*</span>
                                        </label>
                                        <div class="single-input_">
                                            <select name="nationality" class="form-control">
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->country }}"
                                                        {{ @$user->address->nationality == $country->country ? 'selected' : '' }}>
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15">
                                        <label for="">@lang('Bio')</label>
                                        <textarea name="bio" id="bio" class="form-control" maxlength="1200"
                                            placeholder="Say something about Youself...">{{ @$user->address->bio }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="buttorn_wrapper">
                                <button type="submit" class="theme_btn style_1 dashborad_btn money-btn"> <span
                                        class="btn_title">@lang('Submit') <i
                                            class="fa-solid fa-angles-right"></i></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h4>Document KYC</h4>
                        <p>Complete this KYC to post propery listings</p>
                        <br>

                        @if (Auth::user()->doc_kyc_doc_file && Auth::user()->doc_kyc_status == 'accepted')
                            <p>KYC Complete <i class="text-success fa fa-check"></i></p>
                            <table class="table">
                                <tr>
                                    <th>Document Type</th>
                                    <td>{{ Auth::user()->doc_kyc_document_type }}</td>
                                </tr>
                            </table>
                        @elseif(Auth::user()->doc_kyc_doc_file && Auth::user()->doc_kyc_status == 'rejected')
                            <p>Your KYC Has been rejected, you can try again below</p>
                            <table class="table">
                                <tr>
                                    <th>Document Type</th>
                                    <td>{{ Auth::user()->doc_kyc_document_type }}</td>
                                </tr>
                                <tr>
                                    <th>Rejection Reason</th>
                                    <td>{{ Auth::user()->doc_kyc_rejection_reason }}</td>
                                </tr>
                            </table>
                            <br>
                            <form action="{{route('user.profile.update_kyc')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="ui-widget">
                                            <label for="gender">Document Type <i class="text-danger">*</i> : </label>
                                            <select name="doc_type_" id="doc_type" class="form-control" required>
                                                <option value="">--select document type--</option>
                                                <option value="EU National ID Card">EU National ID Card</option>
                                                <option value="ID Card">ID Card</option>
                                                <option value="EU Driving License">EU Driving License</option>
                                                <option value="Others">Others</option>
                                                <option value="Passport">Passport</option>
                                                <option value="EU Resident Card">EU Resident Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ui-widget">
                                            <label for="doc_front">Document(jpeg, jpg, png,pdf only) <i class="text-danger">*</i> : </label>
                                            <input type="file" id="doc" name="doc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit KYC</button>
                            </form>
                        @elseif(Auth::user()->doc_kyc_doc_file && Auth::user()->doc_kyc_status == 'pending')
                            <p>KYC Processing <i class="text-warning fa fa-check"></i>, please check again shortly.</p>
                            <table class="table">
                                <tr>
                                    <th>Document Type</th>
                                    <td>{{ Auth::user()->doc_kyc_document_type }}</td>
                                </tr>
                            </table>
                        @elseif(!Auth::user()->doc_kyc_doc_file && Auth::user()->doc_kyc_status == 'pending')
                            <p>No KYC Documnet Uploaded, you cannot post property listings. Fill the form below to submit
                                KYC.</p>
                                <br>
                            <form action="{{route('user.profile.update_kyc')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="ui-widget">
                                            <label for="gender">Document Type <i class="text-danger">*</i> : </label>
                                            <select name="doc_type_" id="doc_type" class="form-control" required>
                                                <option value="">--select document type--</option>
                                                <option value="EU National ID Card">EU National ID Card</option>
                                                <option value="ID Card">ID Card</option>
                                                <option value="EU Driving License">EU Driving License</option>
                                                <option value="Others">Others</option>
                                                <option value="Passport">Passport</option>
                                                <option value="EU Resident Card">EU Resident Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ui-widget">
                                            <label for="doc_front">Document(jpeg, jpg, png,pdf only) <i class="text-danger">*</i> : </label>
                                            <input type="file" id="doc" name="doc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit KYC</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
