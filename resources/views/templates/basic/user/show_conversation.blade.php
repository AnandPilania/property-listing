@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="dashboard_box mb-30">
            <div class="d-flex justify-content-between align-items-left">
                <h5 class="title mb-25">{{ $conversation->data['name'] }}</h5>

                <a href="{{ route('conversation.index') }}"><i class="fas fa-angle-left"></i>Back</a>

            </div>
            <div class="dashboard_body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card m-0 p-0" id="chat1" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between align-items-left p-3 bg-info text-white border-bottom-0"
                                style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                <div>
                                    @if (isset($conversation->data['admins']) && in_array(Auth::id(), $conversation->data['admins']))
                                        <a href="{{ route('conversation.add_part', $conversation->id) }}"
                                            class="btn btn-light btn-sm m-1"><i class="fas fa-users"></i> Add
                                            Participants</a>
                                    @endif
                                    <button type="button" class="btn btn-primary btn-sm m-1" data-bs-toggle="modal"
                                        data-bs-target="#newConversationModal">
                                        <i class="fas fa-list"></i>Group Info
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="newConversationModal" tabindex="-1"
                                    aria-labelledby="newConversationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newConversationModalLabel">Group
                                                    Info - {{ $conversation->data['name'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                            data-bs-target="#home" type="button" role="tab"
                                                            aria-controls="home" aria-selected="true">Info</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                            data-bs-target="#profile" type="button" role="tab"
                                                            aria-controls="profile"
                                                            aria-selected="false">Participants</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                            data-bs-target="#contact" type="button" role="tab"
                                                            aria-controls="contact"
                                                            aria-selected="false">Invitations</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                        aria-labelledby="home-tab">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    Group Name :
                                                                </th>
                                                                <td>
                                                                    {{ $conversation->data['name'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Group Description :
                                                                </th>
                                                                <td>
                                                                    {{ $conversation->data['description'] }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                                        aria-labelledby="profile-tab">
                                                        <ul class="list-group">
                                                            @foreach ($conversation->getParticipants() as $participant)
                                                                <li class="list-group-item">
                                                                    <a href="#">
                                                                        {{ $participant->firstname }}
                                                                        {{ $participant->lastname }}
                                                                        <br>
                                                                        <i>
                                                                            {{ '@' . $participant->username }}
                                                                        </i>
                                                                    </a>
                                                                    @if (isset($conversation->data['admins']) && in_array(Auth::id(), $conversation->data['admins']))
                                                                        <a href="{{ route('conversation.leave_group', [$conversation->id, $participant->id]) }}"
                                                                            onclick="return confirm('Are you sure you wish to remove this Participant??')"
                                                                            class="btn btn-sm btn-secondary"
                                                                            style="float: right;">Remove</a>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane fade" id="contact" role="tabpanel"
                                                        aria-labelledby="contact-tab">
                                                        @if (isset($invitations))
                                                            <table class="table">
                                                                <thead>
                                                                    <th>Invitee</th>
                                                                    <th>Inviter</th>
                                                                    <th>Date</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($invitations as $invite)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $invite->invitee_u->firstname }}
                                                                                {{ $invite->invitee_u->lastname }}
                                                                                <br>
                                                                                <small><i>{{ '@' . $invite->invitee_u->username }}</i></small>
                                                                            </td>
                                                                            <td>
                                                                                {{ $invite->inviter_u->firstname }}
                                                                                {{ $invite->inviter_u->lastname }}
                                                                                <br>
                                                                                <small><i>{{ '@' . $invite->inviter_u->username }}</i></small>
                                                                            </td>
                                                                            <td>
                                                                                {{ diffForHumans($invite->created_at) }}
                                                                            </td>
                                                                            <td>
                                                                                @if (isset($conversation->data['admins']) && in_array(Auth::id(), $conversation->data['admins']))
                                                                                    <a href="{{ route('conversation.decline_invite', [$invite->conversation->id, $invite->invitee_u->id]) }}"
                                                                                        onclick="return confirm('Are you sure you wish to cancel this Invite?')"
                                                                                        class="btn btn-sm btn-secondary">Cancel</a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>

                                                            @if ($invitations->hasPages())
                                                                <div class="">
                                                                    <div class="col-12 py-4">
                                                                        {{ paginateLinks($invitations) }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div style="height: 400px; overflow-y:auto;">
                                    @foreach ($conversation->messages()->oldest()->take(500)->get() as $message)
                                        @if (isset($message->participation_id))
                                            @if ($message->sender->id == Auth::id())
                                                <div class="d-flex flex-row justify-content-end mb-4">
                                                    <div class="p-3 me-3 border"
                                                        style="border-radius: 15px; background-color: #fbfbfb;">
                                                        <p class="small mb-0">
                                                            <b>{{ $message->sender->firstname }}
                                                                {{ $message->sender->lastname }}</b> -
                                                            <i>{{ '@' . $message->sender->username }}</i>
                                                            <br>
                                                        <p>
                                                            {!! $message->body !!}
                                                        </p>
                                                        <i><small>{{ diffForHumans($message->created_at) }}</small></i>
                                                    </div>
                                                    <img src="{{ asset('/assets/images/frontend/profile/' . $message->sender->image) }}"
                                                        alt="avatar"
                                                        style="width: 45px; height: 100%; border-radius:50%;">


                                                </div>
                                            @else
                                                <div class="d-flex flex-row justify-content-start mb-4">
                                                    <img src="{{ asset('/assets/images/frontend/profile/' . $message->sender->image) }}""
                                                        alt="avatar"
                                                        style="width: 45px; height: 100%; border-radius:50%;">
                                                    <div class="p-3 ms-3"
                                                        style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                        <p class="small mb-0">
                                                            <b>{{ $message->sender->firstname }}
                                                                {{ $message->sender->lastname }}</b> -
                                                            <i>{{ '@' . $message->sender->username }}</i>
                                                            <br>
                                                        <p>
                                                            {!! $message->body !!}
                                                        </p>
                                                        <i><small>{{ diffForHumans($message->created_at) }}</small></i>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-flex flex-row justify-content-start mb-4">
                                                <img src="" alt="avatar"
                                                    style="width: 45px; height: 100%; border-radius:50%;">
                                                <div class="p-3 ms-3"
                                                    style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                    <p class="small mb-0">
                                                        <i> The sender of this message is no longer in this
                                                            chat</i>
                                                        <br>
                                                    <p>
                                                        {!! $message->body !!}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    {{-- <div class="d-flex flex-row justify-content-start mb-4">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                    <div class="ms-3" style="border-radius: 15px;">
                                        <div class="bg-image">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                                                style="border-radius: 15px;" alt="video">
                                            <a href="#!">
                                                <div class="mask"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row justify-content-start mb-4">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                    <div class="p-3 ms-3"
                                        style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                        <p class="small mb-0">...</p>
                                    </div>
                                </div> --}}
                                </div>
                                <form action="{{ route('conversation.send_message', $conversation->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-outline">
                                        <textarea class="form-control" id="textAreaExample" name="message" rows="4"></textarea>
                                        <label class="form-label" for="textAreaExample">Type your
                                            message</label>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        {{-- <div>
                                    <div class="input-group">
                                        <input type="file" name="attachment" id="attachment"
                                            class="form-control">
                                        <label class="input-group-text" for="attachment">
                                            <i class="fas fa-paperclip"></i>
                                            <!-- Font Awesome paperclip icon for attachment -->
                                        </label>
                                    </div>
                                </div> --}}

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
