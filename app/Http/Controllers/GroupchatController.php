<?php

namespace App\Http\Controllers;

use App\Models\GroupChatInvite;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Chat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class GroupchatController extends Controller
{
    //return all the authorized user groups
    public function index(Request $request)
    {
        $pageTitle = "My conversations";
        $participantModel = User::where('id', auth()->id())->first();
        if ($request->page) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        $chats = Chat::conversations()->setPaginationParams(['sorting' => 'desc', 'perPage' => getPaginate(20), 'page' => $page])
            ->setParticipant($participantModel)
            ->get();

        $invitations = GroupChatInvite::where('invitee_id', Auth::id())->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(getPaginate(20));

        return view($this->activeTemplate . 'user.my_conversations', compact('chats', 'pageTitle', 'invitations'));
    }

    //create a new conversation
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $user = User::where('id', auth()->id())->first();
            $data = ['name' => $request->name, 'description' => $request->desc, 'admins' => [$user->id]];
            $conversation = Chat::createConversation([$user]);
            $conversation->update(['data' => $data]);
            $notify[] = ['success', 'Conversation created successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Create Conversation.'];
            return back()->withNotify($notify);
        }
    }

    //show a conversation
    public function show($id)
    {
        $conversation = Chat::conversations()->getById($id);
        $pageTitle = 'Conversation | ' . $conversation->data['name'];
        $invitations = GroupChatInvite::where('conversation_id', $id)->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.show_conversation', compact('conversation', 'pageTitle', 'invitations',));
    }

    //add participants to a conversation
    public function add_part($id)
    {
        $conversation = Chat::conversations()->getById($id);
        $pageTitle = 'Add Participants | ' . $conversation->data['name'];
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.add_part', compact('conversation', 'pageTitle', 'countries'));
    }

    public function search_users(Request $request, $conversation_id = null)
    {
        try {
            $query = User::query();

            // Basic Search by Username
            if ($request->has('username')) {
                $query->where('username', 'like', '%' . $request->input('username') . '%');
            }

            // Advanced Search Fields
            if ($request->has('toggleAdvancedSearch') && $request->input('toggleAdvancedSearch')) {
                // Gender
                if ($request->filled('gender')) {
                    $query->where('address->gender', $request->input('gender'));
                }

                // Pet Ownership
                if ($request->filled('petOwnership')) {
                    $query->where('address->pet_ownership', $request->input('petOwnership'));
                }

                // Ethnicity
                if ($request->filled('ethnicity')) {
                    $query->where('address->ethnicity', $request->input('ethnicity'));
                }

                // Nationality
                if ($request->filled('nationality')) {
                    $query->where('address->nationality', $request->input('nationality'));
                }
                // Include other advanced search fields here
            }

            $results = $query->paginate(getPaginate(20));

            // dd($results);

            if ($conversation_id == null) {
                return back()->with(compact('results'));
            } else {
                $conversation = Chat::conversations()->getById($conversation_id);
                $pageTitle = 'Add Participants | ' . $conversation->data['name'];
                $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
                return view($this->activeTemplate . 'user.add_part', compact('conversation', 'pageTitle', 'results', 'countries'));
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Perform Search.'];
            return back()->withNotify($notify);
        }
    }

    //send Message to a conversation
    public function send_message(Request $request, $id)
    {
        $conversation = Chat::conversations()->getById($id);
        $request->validate([
            'message' => 'required',
            'attachment' => 'nullable|file|max:10240'
        ]);

        try {
            $cleanedHtmlString = Purifier::clean($request->message);
            $message = Chat::message($cleanedHtmlString)
                ->type('text')
                ->from(User::where('id', Auth::id())->first())
                ->to($conversation)
                ->send();


            $notify[] = ['success', 'Message sent'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Send Message.'];
            return back()->withNotify($notify);
        }
    }

    public function invite_users(Request $request, $group_id, $user_id)
    {
        try {
            $check_invitation = GroupChatInvite::where('conversation_id', $group_id)->where('invitee_id', $user_id)->where('status', 'pending')->count();

            if ($check_invitation > 0) {
                $notify[] = ['error', 'User Already invited to conversation.'];
                return back()->withNotify($notify);
            } else {
                $make_invitation = new GroupChatInvite;
                $make_invitation->invitee_id = $user_id;
                $make_invitation->inviter_id = Auth::id();
                $make_invitation->conversation_id = $group_id;
                $make_invitation->save();
                $notify[] = ['success', 'Invite sent.'];
                return back()->withNotify($notify);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Send Invite.'];
            return back()->withNotify($notify);
        }
    }

    public function accept_invite(Request $request, $group_id, $user_id)
    {
        try {
            $check_invitation = GroupChatInvite::where('conversation_id', $group_id)->where('invitee_id', $user_id)->where('status', 'pending')->count();

            if ($check_invitation > 0) {
                GroupChatInvite::where('conversation_id', $group_id)->where('invitee_id', $user_id)->update([
                    'status' => 'accepted'
                ]);

                //add participant to group chat
                $conversation = Chat::conversations()->getById($group_id);
                $part = User::where('id', $user_id)->first();
                Chat::conversation($conversation)->addParticipants([$part]);

                $message = Chat::message($part->username . ' Joined the chat')
                    ->type('text')
                    ->from($part)
                    ->to($conversation)
                    ->send();

                $notify[] = ['success', 'Invite Accepted.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'No pending Invites found.'];
                return back()->withNotify($notify);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Accept Invite.'];
            return back()->withNotify($notify);
        }
    }

    public function leave_group(Request $request, $group_id, $user_id)
    {
        try {

            //remove participant from group chat
            $conversation = Chat::conversations()->getById($group_id);
            $part = User::where('id', $user_id)->first();

            //ensure that only the participant or an admin is allowed to remove a participant
            if (in_array(Auth::id(), $conversation->data['admins']) || $user_id = Auth::id()) {
                $message = Chat::message($part->username . ' Left the chat')
                    ->type('text')
                    ->from($part)
                    ->to($conversation)
                    ->send();
                Chat::conversation($conversation)->removeParticipants([$part]);
                $notify[] = ['success', 'Exit Successful.'];
                return back()->withNotify($notify);
            } else {
                abort(403, 'You are not allowed to remove this user from the conversation');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Accept Invite.'];
            return back()->withNotify($notify);
        }
    }

    public function decline_invite(Request $request, $group_id, $user_id)
    {
        try {
            $check_invitation = GroupChatInvite::where('conversation_id', $group_id)->where('invitee_id', $user_id)->where('status', 'pending')->count();

            if ($check_invitation > 0) {
                GroupChatInvite::where('conversation_id', $group_id)->where('invitee_id', $user_id)->update([
                    'status' => 'rejected'
                ]);
                $notify[] = ['success', 'Invite Declined.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'No pending Invites found.'];
                return back()->withNotify($notify);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
            $notify[] = ['error', 'Failed to Declined Invite.'];
            return back()->withNotify($notify);
        }
    }

    public function share_prop_to_conversation(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|array',
            'chat_id.*' => 'required',
            'prop_id' => 'required',
        ]);

        if ($request->chat_id && count($request->chat_id) > 0) {
            //get the user information
            $part = User::where('id', Auth::id())->first();

            //get the property information
            $prop = Property::where('id', $request->prop_id)->first();
            $prop_url = route('property.details', [slug($prop->title), $prop->id]);

            //construct the message
            $message_str = "@" . $part->username . " Shared the property : <u><a href='" . $prop_url . "' target='_blank'>" . $prop->title . "</a></u>";

            //send the message to each of the user's conversations
            foreach ($request->chat_id as $conversation) {
                $conversation = Chat::conversations()->getById($conversation);
                $message = Chat::message($message_str)
                    ->type('text')
                    ->from($part)
                    ->to($conversation)
                    ->send();
            }
            $notify[] = ['success', 'Property shared to selected conversations'];
            return back()->withNotify($notify);
        }
    }
}
