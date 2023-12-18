<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Chat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GroupchatController extends Controller
{
    //return all the authorized user groups
    public function index()
    {
        $pageTitle = "My conversations";
        $participantModel = User::where('id', auth()->id())->first();
        $chats = Chat::conversations()->setPaginationParams(['sorting' => 'desc'])
            ->setParticipant($participantModel)
            ->get();

        return view($this->activeTemplate . 'user.my_conversations', compact('chats', 'pageTitle'));
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
        return view($this->activeTemplate . 'user.show_conversation', compact('conversation', 'pageTitle'));
    }

    //add participants to a conversation
    public function add_part($id)
    {
        $conversation = Chat::conversations()->getById($id);
        $pageTitle = 'Add Participants | ' . $conversation->data['name'];
        return view($this->activeTemplate . 'user.add_part', compact('conversation', 'pageTitle'));
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
                    $query->where('gender', $request->input('gender'));
                }

                // Pet Ownership
                if ($request->filled('petOwnership')) {
                    $query->where('pet_ownership', $request->input('petOwnership'));
                }

                // Ethnicity
                if ($request->filled('ethnicity')) {
                    $query->where('ethnicity', $request->input('ethnicity'));
                }

                // Nationality
                if ($request->filled('nationality')) {
                    $query->where('nationality', $request->input('nationality'));
                }
                // Include other advanced search fields here
            }

            $results = $query->get();

            // dd($results);

            if ($conversation_id == null) {
                return back()->with(compact('results'));
            } else {
                $conversation = Chat::conversations()->getById($conversation_id);
                $pageTitle = 'Add Participants | ' . $conversation->data['name'];
                return view($this->activeTemplate . 'user.add_part', compact('conversation', 'pageTitle', 'results'));
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
            $message = Chat::message($request->message)
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
}
