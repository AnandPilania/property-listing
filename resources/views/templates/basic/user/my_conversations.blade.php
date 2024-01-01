@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="dashboard_box mb-30">
            <h4 class="title mb-25">@lang('My conversations ')</h4>
            <div class="dashboard_body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#newConversationModal">
                            New conversation <i class="fa fa-plus"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="newConversationModal" tabindex="-1"
                            aria-labelledby="newConversationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('conversation.store') }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newConversationModalLabel">New conversation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="desc">Description(optional)</label>
                                                <textarea name="desc" class="form-control"></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="converations-tab" data-bs-toggle="tab"
                                    data-bs-target="#converations" type="button" role="tab"
                                    aria-controls="converations" aria-selected="true">My
                                    conversations</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="invitations-tab" data-bs-toggle="tab"
                                    data-bs-target="#invitations" type="button" role="tab" aria-controls="invitations"
                                    aria-selected="false">Invitations</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="converations" role="tabpanel"
                                aria-labelledby="converations-tab">
                                @if (isset($chats))
                                    <ul class="list-group">
                                        @foreach ($chats as $chat)
                                            <li class="list-group-item">
                                                <a href="{{ route('conversation.show', $chat->id) }}">
                                                    {{ json_decode($chat->data)->name }}
                                                    <br>
                                                    <small>{{ json_decode($chat->data)->description }}</small>
                                                </a>
                                                <br>
                                                <a href="{{route('conversation.leave_group', [$chat->id, Auth::id()])}}" onclick="return confirm('Are you sure you wish to exit this Conversation?')" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i> Exit converation</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if ($chats->hasPages())
                                        <div class="">
                                            <div class="col-12 py-4">
                                                {{ paginateLinks($chats) }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="tab-pane fade" id="invitations" role="tabpanel" aria-labelledby="invitations-tab">
                                @if (isset($invitations))
                                    <table class="table">
                                        <thead>
                                            <th>Conversation</th>
                                            <th>Inviter</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($invitations as $invite)
                                                <tr>
                                                    <td>
                                                        {{ $invite->conversation->data['name'] }}
                                                        <br>
                                                        <small>{{ $invite->conversation->data['description'] }}</small>
                                                    </td>
                                                    <td>
                                                        {{ $invite->inviter_u->firstname }} {{ $invite->inviter_u->lastname }}
                                                        <br>
                                                        <small><i>{{'@'.$invite->inviter_u->username }}</i></small>
                                                    </td>
                                                    <td>
                                                        {{diffForHumans($invite->created_at)}}
                                                    </td>
                                                    <td>
                                                        <a href="{{route('conversation.accept_invite', [$invite->conversation->id, $invite->invitee_u->id])}}" onclick="return confirm('Are you sure you wish to accept this Invite?')" class="btn btn-sm btn-primary">Accept</a>
                                                        <br>
                                                        <br>
                                                        <a href="{{route('conversation.decline_invite', [$invite->conversation->id, $invite->invitee_u->id])}}" onclick="return confirm('Are you sure you wish to decline this Invite?')" class="btn btn-sm btn-secondary">Decline</a>
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
                </div>
            </div>
        </div>

    </div>
@endsection
