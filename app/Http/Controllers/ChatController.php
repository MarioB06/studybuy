<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get all chats where the user is either user1 or user2
        $chats = Chat::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['product', 'user1', 'user2', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('chats.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        $userId = auth()->id();

        // Check if user is part of this chat
        if ($chat->user1_id !== $userId && $chat->user2_id !== $userId) {
            abort(403, 'Unauthorized access to this chat.');
        }

        // Mark messages as read
        $chat->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Load relationships
        $chat->load(['product', 'user1', 'user2', 'messages.user']);

        return view('chats.show', compact('chat'));
    }

    public function store(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        // Check if user is part of this chat
        if ($chat->user1_id !== $userId && $chat->user2_id !== $userId) {
            abort(403, 'Unauthorized access to this chat.');
        }

        // Check if product is abgeschlossen
        if ($chat->product->abgeschlossen) {
            return redirect()->route('chats.show', $chat)->with('error', 'Chat ist beendet. Transaktion abgeschlossen.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => $userId,
            'message' => $validated['message'],
        ]);

        // Update last_message_at on chat
        $chat->update(['last_message_at' => now()]);

        return redirect()->route('chats.show', $chat)->with('success', 'Nachricht gesendet!');
    }
}
