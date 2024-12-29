<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function accessAdmin(User $user) {
        return $user->role == 1;
    }
    public function accessOffice(User $user) {
        return $user->role == 2;
    }
    public function accessUser(User $user) {
        return $user->role == 3;
    }
}
