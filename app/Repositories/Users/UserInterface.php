<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserInterface
{
    public function all(): Collection;
    public function getAllUsers(): Collection;
    public function updateUserSettings(array $data): User;
    public function validatePhoneNumber($phoneNumber): bool;
    public function impersonate(User $user): void;
    public function leaveImpersonation(): void;
    public function getEligibleForNotifications(): Collection;
}
