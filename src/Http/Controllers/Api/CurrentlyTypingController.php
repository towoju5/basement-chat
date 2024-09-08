<?php

declare(strict_types=1);

namespace BasementChat\Basement\Http\Controllers\Api;

use BasementChat\Basement\Events\CurrentlyTyping;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CurrentlyTypingController extends Controller
{
    /**
     * Broadcast the currently typing event to the receiver.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $contact
     */
    public function __invoke(
        Authenticatable $contact,
    ): Response {
        /** @var int $senderId */
        $senderId = Auth::id();

        broadcast(new CurrentlyTyping(
            senderId: $senderId,
            receiverId: $contact->id,
        ));

        return response()->noContent();
    }
}
