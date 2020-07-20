<?php

namespace Telefonica\Http\Policies;

use App\Models\User;

/**
 * Class TelefonicaPolicy.
 *
 * @package Finder\Http\Policies
 */
class TelefonicaPolicy
{
    /**
     * Create a telefonica.
     *
     * @param  User   $authUser
     * @param  string $telefonicaClass
     * @return bool
     */
    public function create(User $authUser, string $telefonicaClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a telefonica.
     *
     * @param  User  $authUser
     * @param  mixed $telefonica
     * @return bool
     */
    public function get(User $authUser, $telefonica)
    {
        return $this->hasAccessToTelefonica($authUser, $telefonica);
    }

    /**
     * Determine if an authenticated user has access to a telefonica.
     *
     * @param  User $authUser
     * @param  $telefonica
     * @return bool
     */
    private function hasAccessToTelefonica(User $authUser, $telefonica): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($telefonica instanceof User && $authUser->id === optional($telefonica)->id) {
            return true;
        }

        if ($authUser->id === optional($telefonica)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a telefonica.
     *
     * @param  User  $authUser
     * @param  mixed $telefonica
     * @return bool
     */
    public function update(User $authUser, $telefonica)
    {
        return $this->hasAccessToTelefonica($authUser, $telefonica);
    }

    /**
     * Delete a telefonica.
     *
     * @param  User  $authUser
     * @param  mixed $telefonica
     * @return bool
     */
    public function delete(User $authUser, $telefonica)
    {
        return $this->hasAccessToTelefonica($authUser, $telefonica);
    }
}
