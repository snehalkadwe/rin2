<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Collection;
use Twilio\Rest\Client;

class UserRepository implements UserInterface
{
    /**
     * Get all users.
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * Retrieve all users with their unread notifications.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers(): Collection
    {
        $adminEmail = config('app.admin_email');
        return User::with(['unreadNotifications'])
            ->where('email', '!=', $adminEmail)
            ->get();
    }

    /**
     * Update user settings.
     *
     * @param array $data
     * @return \App\Models\User
     * @throws \InvalidArgumentException if the phone number is invalid.
     */
    public function updateUserSettings(array $data): User
    {
        $user = auth()->user();
        // Update user settings
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'notification_switch' => $data['notification_switch'] ?? false,
        ]);

        return $user;
    }

    /**
     * Validate phone number using Twilio Lookup API.
     *
     * @throws \InvalidArgumentException if the phone number is invalid.
     */
    public function validatePhoneNumber($phoneNumber): bool
    {
        $sID = config('services.twilio.sid');
        $authToken = config('services.twilio.token');
        $twilio = new Client($sID, $authToken);
        try {
            // return true;
            $payload = $twilio->lookups->v2->phoneNumbers($phoneNumber)->fetch(['fields' => 'line_type_intelligence']);

            // If the phone number is not valid return false
            if ($payload->valid === false) {
                return false;
            }

            // Check the line type intellience if the given number is for mobile or not
            if (
                isset($payload->lineTypeIntelligence['type'])
                && strtolower($payload->lineTypeIntelligence['type']) === 'mobile'
            ) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Impersonate a selected user.
     */
    public function impersonate(User $user): void
    {
        $authUser = auth()->user();

        if (! $authUser->canImpersonate()) {
            abort(403, 'Unauthorized action.');
        }

        $authUser->impersonate($user);
    }

    /**
     * Leave impersonation mode.
     */
    public function leaveImpersonation(): void
    {
        auth()->user()->leaveImpersonation();
    }

    /**
     * Get users eligible for notifications.
     */
    public function getEligibleForNotifications(): Collection
    {
        return User::where('notification_switch', true)->get();
    }
}
