<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id1}.{id2}', function ($user, $id1, $id2) {
    // Hanya izinkan user masuk jika ID-nya adalah salah satu peserta chat
    return (int) $user->id === (int) $id1 || (int) $user->id === (int) $id2;
});