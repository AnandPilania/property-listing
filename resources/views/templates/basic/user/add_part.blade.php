@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="dashboard_box mb-30">
            <h4 class="title mb-25">@lang('My conversations ')</h4>
            <div class="dashboard_body">
                <div class="row">
                    <div class="col-lg-12">
                        Add Prticipants to <b> {{ $conversation->data['name'] }}</b>
                        <hr>

                        <form action="{{ route('conversation.search_users', $conversation->id) }}" method="POST">
                            @csrf
                            <div class="mb-3 col-sm-12">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username">
                            </div>

                            <!-- Toggle Advanced Search Button -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="toggleAdvancedSearch">
                                <label class="form-check-label" for="toggleAdvancedSearch">Toggle Advanced
                                    Search</label>
                            </div>

                            <!-- Advanced Search Fields (Initially Hidden) -->
                            <div id="advancedSearchFields" style="display: none;">

                                <!-- Gender -->
                                <div class="row">
                                    <div class="mb-3 col-sm-6">
                                        <label for="gender" class="form-label">Gender:</label>
                                        <select class="form-select" id="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="nonBinary">Non-binary</option>
                                            <option value="preferNotToSay">Prefer not to say</option>
                                        </select>
                                    </div>

                                    <!-- Pet Ownership -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="petOwnership" class="form-label">Pet Ownership:</label>
                                        <select class="form-select" id="petOwnership">
                                            <option value="ownPets">I own pets</option>
                                            <option value="comfortableWithPets">I am comfortable with pets</option>
                                            <option value="petFree">I prefer a pet-free environment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Ethnicity -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="ethnicity" class="form-label">Ethnicity:</label>
                                        <select class="form-select" id="ethnicity">
                                            <option value="asian">Asian</option>
                                            <option value="black">Black/African American</option>
                                            <option value="hispanic">Hispanic/Latino</option>
                                            <option value="white">White/Caucasian</option>
                                            <option value="otherEthnicity">Other</option>
                                            <option value="preferNotToSayEthnicity">Prefer not to say</option>
                                        </select>
                                    </div>

                                    <!-- Nationality -->
                                    <div class="mb-3 col-sm-6">
                                        <label for="nationality" class="form-label">Nationality:</label>
                                        <input type="text" class="form-control" id="nationality"
                                            placeholder="Enter nationality">
                                    </div>
                                </div>

                                <!-- Include other advanced search fields here -->

                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        <hr>


                        <div class="container">
                            <h1 class="mb-4">User Profile Search Results</h1>

                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-2">
                                @isset($results)
                                    @if ($results->isEmpty())
                                        <p>No users found.</p>
                                    @else
                                        @foreach ($results as $user)
                                            <!-- User Card 1 -->
                                            <div class="col">
                                                <div class="card h-100">
                                                    <img src="profile1.jpg" class="card-img-top" alt="Profile Picture">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <b>{{$user->firstname}} {{$user->lastname}}</b>
                                                        </h5>
                                                        <p>
                                                            <i>{{'@'.$user->username}}</i>
                                                            <hr>
                                                            <b>Nationality</b>: {{$user->address->nationality}}
                                                            <br>
                                                            <b>Ethnicity</b>: {{$user->address->ethnicity}}
                                                            <br>
                                                            <b>Pet Reference</b>: {{$user->address->pet_ownership}}
                                                            <br>
                                                            <b>Bio</b>: {{$user->address->bio}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
