<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Models\Participation;

class GroupChatInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'invitee_id',
        'inviter_id',
        'status'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function invitee()
    {
        return $this->belongsTo(Participation::class, 'invitee_id', 'id');
    }

    public function inviter()
    {
        return $this->belongsTo(Participation::class, 'inviter_id', 'id');
    }

    public function invitee_u()
    {
        return $this->belongsTo(User::class, 'invitee_id', 'id');
    }

    public function inviter_u()
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }
}
