<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'sender_id',
        'recipient_id',
    ];
    function sender($id)
    {
        $sender = User::where('sender_id', '=', $id)->firstOrFail();
        return $sender;
    }

    function recipient($id)
    {
        $recipient = User::where('recipient_id', '=', $id)->firstOrFail();
        return $recipient;
    }
}
