<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Users\UserInterface;
use App\Http\Requests\UserSettingsRequest;

class UserController extends Controller
{
    protected UserInterface $userRepository;

    /**
     * UserController constructor.
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of users with their unread notifications.
     */
    public function index()
    {
        $users = $this->userRepository->getAllUsers();

        return view('users.index', compact('users'));
    }

    /**
     * Impersonate a user by their ID.
     */
    public function impersonate(User $user)
    {
        $this->userRepository->impersonate($user);

        return redirect()->route('dashboard');
    }

    /**
     * Leave impersonation and return to the original user.
     */
    public function leaveImpersonation()
    {
        $this->userRepository->leaveImpersonation();

        return redirect()->route('users.index');
    }

    /**
     * Show the user settings form.
     */
    public function settings()
    {
        return view('users.settings');
    }


    /**
     * Update user settings.
     */
    public function updateSettings(UserSettingsRequest $request)
    {
        $validatedData = $request->validated();

        // Only validate phone number if provided
        if (!empty($validatedData['phone_number'])) {
            try {
                $isValid = $this->userRepository->validatePhoneNumber($validatedData['phone_number']);
                if (!$isValid) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['phone_number' => 'Invalid phone number']);
                }
            } catch (\InvalidArgumentException $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['phone_number' => $e->getMessage()]);
            }
        }

        // If phone validation passes, proceed with update
        $this->userRepository->updateUserSettings($validatedData);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
