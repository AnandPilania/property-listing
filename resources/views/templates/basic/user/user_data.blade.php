@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--=======-**  Login Start **-=======-->
    <section class="login_area login_bg pt-70 pb-80 md-pt-50 md-pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-lg-5 col-md-8">
                    <div class="login_wrapper">
                        <h4 class="loging_text mb-20">{{ __($pageTitle) }}</h4>

                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="modal_body_wrapper">
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('First Name')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control"
                                                name="firstname"value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Last Name')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control"
                                                name="lastname"value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group profile mb-15">
                                    <label for="first_name">@lang('Address')<span class="text-danger">*</span> </label>
                                    <div class="single-input_">
                                        <input type="text" class="form-control"
                                            name="address"value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('State')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control"
                                                name="state"value="{{ old('state') }}">
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Zip Code')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <input type="text" class="form-control"
                                                name="city"value="{{ old('city') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Gender')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Non-binary"
                                                    {{ old('gender') == 'Non-binary' ? 'selected' : '' }}>Non-binary
                                                </option>
                                                <option value="Prefer not to say"
                                                    {{ old('gender') == 'Prefer not to say' ? 'selected' : '' }}>Prefer
                                                    not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Pet Ownership')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <select name="pet_ownership" id="pet_ownership" class="form-control">
                                                <option value="I own pets"
                                                    {{ old('pet_ownership') == 'I own pets' ? 'selected' : '' }}>I own
                                                    pets</option>
                                                <option value="I am comfortable with pets"
                                                    {{ old('pet_ownership') == 'I am comfortable with pets' ? 'selected' : '' }}>
                                                    I am comfortable with pets</option>
                                                <option value="I prefer a pet-free environment"
                                                    {{ old('pet_ownership') == 'I prefer a pet-free environment' ? 'selected' : '' }}>
                                                    I prefer a pet-free environment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Ethnicity')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <select name="ethnicity" id="ethnicity" class="form-control">
                                                <option value="Asian"
                                                    {{ old('ethnicity') == 'Asian' ? 'selected' : '' }}>Asian</option>
                                                <option value="Black/African American"
                                                    {{ old('ethnicity') == 'Black/African American' ? 'selected' : '' }}>
                                                    Black/African American</option>
                                                <option value="Hispanic/Latino"
                                                    {{ old('ethnicity') == 'Hispanic/Latino' ? 'selected' : '' }}>
                                                    Hispanic/Latino</option>
                                                <option value="White/Caucasian"
                                                    {{ old('ethnicity') == 'White/Caucasian' ? 'selected' : '' }}>
                                                    White/Caucasian</option>
                                                <option value="Other"
                                                    {{ old('ethnicity') == 'Other' ? 'selected' : '' }}>Other</option>
                                                <option value="Prefer not to say"
                                                    {{ old('ethnicity') == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group profile mb-15 col-sm-6">
                                        <label for="first_name">@lang('Nationality')<span class="text-danger">*</span> </label>
                                        <div class="single-input_">
                                            <select name="nationality" class="form-control">
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->country }}">{{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="register_bottom mb-15">
                                    <button class="theme_btn style_1"type="submit"><span
                                            class="btn_title">@lang('Save')<i
                                                class="fa-solid fa-angles-right"></i></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======-**  Login End **-=======-->
@endsection
