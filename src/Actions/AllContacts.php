<?php

declare(strict_types=1);

namespace BasementChat\Basement\Actions;

use BasementChat\Basement\Contracts\AllContacts as AllContactsContract;
use BasementChat\Basement\Data\ContactData;
use BasementChat\Basement\Data\PrivateMessageData;
use BasementChat\Basement\Facades\Basement;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

class AllContacts implements AllContactsContract
{
    /**
     * Get all contact list.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $user
     *
     * @return \Illuminate\Support\Collection<int,\BasementChat\Basement\Data\ContactData>
     */
    public function all(Authenticatable $user): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int,Authenticatable&\BasementChat\Basement\Contracts\User> $contacts */
        $contacts = Basement::newUserModel()
            ->addSelectLastPrivateMessageId($user)
            ->addSelectUnreadMessages($user)
            ->get();

        $contacts->append('avatar');
        $contacts->load('lastPrivateMessage');

        return $contacts
            ->sortByDesc('lastPrivateMessage.id')
            ->values()
            ->map(fn(Authenticatable $contact): ContactData => $this->convertToContactData($contact));
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $contact
     */
    protected function convertToContactData(Authenticatable $contact): ContactData
    {
        return new ContactData(
            id: (int)$contact->id,
            name: $contact->name,
            avatar: $contact->avatar,
            avatarText: $contact->avatarText,
            last_private_message: (static fn() => $contact->lastPrivateMessage !== null ? new PrivateMessageData(
                receiver_id: (int)$contact->lastPrivateMessage->receiver_id,
                sender_id: (int)$contact->lastPrivateMessage->sender_id,
                type: $contact->lastPrivateMessage->type,
                value: $contact->lastPrivateMessage->value,
                id: (int)$contact->lastPrivateMessage->id,
                created_at: $contact->lastPrivateMessage->created_at,
                read_at: $contact->lastPrivateMessage->read_at,
            ) : null)(),
            unread_messages: (int)$contact->unread_messages,
        );
    }
}
