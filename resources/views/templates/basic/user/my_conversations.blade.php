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
                        @if (isset($chats))
                            <ul class="list-group">
                                @foreach ($chats as $chat)
                                    <li class="list-group-item">
                                        <a href="{{ route('conversation.show', $chat->id) }}">
                                            {{ $chat->id }} - {{ json_decode($chat->data)->name }}
                                            <br>
                                            <small>{{ json_decode($chat->data)->description}}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
