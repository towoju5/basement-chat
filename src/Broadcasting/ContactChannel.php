<?php

declare(strict_types=1);

namespace BasementChat\Basement\Broadcasting;

use BasementChat\Basement\Data\ContactData;
use BasementChat\Basement\Facades\Basement;
use Illuminate\Contracts\Auth\Authenticatable;

class ContactChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $user
     *
     * @return array<string,mixed>|null
     */
    public function join(Authenticatable $user, int $id): ?array
    {
        if ($user->id !== $id) {
            return null;
        }

        /** @var \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $contact */
        $contact = Basement::newUserModel()->findOrFail($user->id);
        $contact->append('avatar');
        $contact->append('avatarText');
        
        return (new ContactData(
            id: (int)$contact->id,
            name: $contact->name,
            avatar: $contact->avatar,
            avatarText: $contact->avatarText,
            last_private_message: null,
        ))->toArray();
    }
}
