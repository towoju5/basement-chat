<?php

declare(strict_types=1);

namespace BasementChat\Basement\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

interface AllContacts
{
    /**
     * Get all contact list.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable&\BasementChat\Basement\Contracts\User $user
     *
     * @return \Illuminate\Support\Collection<int,\BasementChat\Basement\Data\ContactData>
     */
    public function all(Authenticatable $user): Collection;
}
