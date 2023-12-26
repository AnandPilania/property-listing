@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="dashboard_box mb-30">
            <h4 class="title mb-25">@lang('My conversations ')</h4>
            <div class="dashboard_body">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('conversation.show', $conversation->id) }}"><i class="fas fa-angle-left"></i>
                            Back</a> <br>
                        Add Prticipants to <b> {{ $conversation->data['name'] }}</b>
                        <hr>

                        <form action="{{ route('conversation.search_users', $conversation->id) }}" method="GET">
                            {{-- @csrf --}}
                            <div class="mb-3 col-sm-12">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter username">
                            </div>

                            <!-- Toggle Advanced Search Button -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="toggleAdvancedSearch"
                                    name="toggleAdvancedSearch">
                                <label class="form-check-label" for="toggleAdvancedSearch">Toggle Advanced
                                    Search</label>
                            </div>

                            <!-- Advanced Search Fields (Initially Hidden) -->
                            <div id="advancedSearchFields" style="display: none;">

                                <!-- Gender -->
                                <div class="row">
                                    <div class="mb-3 col-sm-6">
                                        <label for="gender" class="form-label">Gender:</label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Non-binary">Non-binary</option>
                                            <option value="Prefer not to say">Prefer not to say</option>
                                        </select>
                                    </div>

                                    <!-- Pet Ownership -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="petOwnership" class="form-label">Pet Ownership:</label>
                                        <select class="form-select" id="petOwnership" name="petOwnership">
                                            <option value="I own pets">I own pets</option>
                                            <option value="I am comfortable with pets">I am comfortable with pets</option>
                                            <option value="I prefer a pet-free environment">I prefer a pet-free environment
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Ethnicity -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="ethnicity" class="form-label">Ethnicity:</label>
                                        <select class="form-select" id="ethnicity" name="ethnicity">
                                            <option value="Asian">Asian</option>
                                            <option value="Black/African American">Black/African American</option>
                                            <option value="Hispanic/Latino">Hispanic/Latino</option>
                                            <option value="White/Caucasian">White/Caucasian</option>
                                            <option value="Other">Other</option>
                                            <option value="Prefer not to say">Prefer not to say</option>
                                        </select>
                                    </div>

                                    <!-- Nationality -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="nationality" class="form-label">Nationality:</label>
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

                                <!-- Include other advanced search fields here -->

                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="submit" class="btn btn-primary">Show All Users</button>
                        </form>
                        <hr>


                        <div class="container">
                            <h1 class="mb-4">User Profile Search Results</h1>

                            <div class="row">
                                @isset($results)
                                    @if ($results->isEmpty())
                                        <p>No users found.</p>
                                    @else
                                        @foreach ($results as $user)
                                            <!-- User Card 1 -->
                                            @if (gs()->require_sub_for_search_res_disp == 1)
                                                @if (user_has_active_plan($user->id))
                                                    <div class="col-sm-6">
                                                        <div class="card h-100">
                                                            <img src="{{ asset('/assets/images/frontend/profile/' . $user->image) }}"
                                                                class="card-img-top" alt="Profile Picture">
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <b>{{ $user->firstname }} {{ $user->lastname }}</b>
                                                                </h5>
                                                                <p>
                                                                    <i>{{ '@' . $user->username }}</i>
                                                                    <hr>
                                                                    <b>Nationality</b>: {{ ($user->address->nationality) ? $user->address->nationality : 'N/A' }}
                                                                    <br>
                                                                    <b>Ethnicity</b>:
                                                                    {{ $user->address->ethnicity ? $user->address->ethnicity : 'N/A' }}
                                                                    <br>
                                                                    <b>Pet Reference</b>:
                                                                    {{ $user->address->pet_ownership ? $user->address->pet_ownership : 'N/A' }}
                                                                    <br>
                                                                    <b>Gender</b>:
                                                                    {{ $user->address->gender ? $user->address->gender : 'N/A' }}
                                                                    <br>
                                                                    <b>Bio</b>:
                                                                    {{ $user->address->bio ? $user->address->bio : '' }}
                                                                </p>
                                                                <a href="{{ route('conversation.invite_users', [$conversation->id, $user->id]) }}"
                                                                    class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i>
                                                                    Invite</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-sm-6">
                                                    <div class="card h-100">
                                                        <img src="{{ asset('/assets/images/frontend/profile/' . $user->image) }}"
                                                            class="card-img-top" alt="Profile Picture">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <b>{{ $user->firstname }} {{ $user->lastname }}</b>
                                                            </h5>
                                                            <p>
                                                                <i>{{ '@' . $user->username }}</i>
                                                                <hr>
                                                                {{-- <b>Nationality</b>: {{ ($user->address->nationality) ? $user->address->nationality : 'N/A' }} --}}
                                                                <br>
                                                                <b>Ethnicity</b>:
                                                                {{ $user->address->ethnicity ? $user->address->ethnicity : 'N/A' }}
                                                                <br>
                                                                <b>Pet Reference</b>:
                                                                {{ $user->address->pet_ownership ? $user->address->pet_ownership : 'N/A' }}
                                                                <br>
                                                                <b>Gender</b>:
                                                                {{ $user->address->gender ? $user->address->gender : 'N/A' }}
                                                                <br>
                                                                <b>Bio</b>:
                                                                {{ $user->address->bio ? $user->address->bio : '' }}
                                                            </p>
                                                            <a href="{{ route('conversation.invite_users', [$conversation->id, $user->id]) }}"
                                                                class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i>
                                                                Invite</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if ($results->hasPages())
                                            <div class="">
                                                <div class="col-12 py-4">
                                                    {{ paginateLinks($results) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endisset
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script>
        // Toggle Advanced Search Fields
        document.getElementById('toggleAdvancedSearch').addEventListener('change', function() {
            var advancedSearchFields = document.getElementById('advancedSearchFields');
            advancedSearchFields.style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection
