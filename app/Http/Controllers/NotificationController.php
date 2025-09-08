<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Repositories\Notifications\NotificationInterface;
use App\Repositories\Users\UserInterface;
use App\Http\Requests\StoreNotificationRequest;

class NotificationController extends Controller
{
    protected NotificationInterface $notifications;
    protected UserInterface $users;

    /**
     * NotificationController constructor.
     */
    public function __construct(
        NotificationInterface $notifications,
        UserInterface $users
    ) {
        $this->notifications = $notifications;
        $this->users = $users;
    }

    /**
     * Display a listing of notifications with optional filters.
     */
    public function index(Request $request): View
    {
        $notifications = $this->notifications->getAllNotificationsWithFilters(
            $request->type,
            $request->user_id
        );

        $users = $this->users->all();

        return view('notifications.index', compact('notifications', 'users'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create(): View
    {
        $users = $this->users->all();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(StoreNotificationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($validatedData['destination'] === 'all') {
            $this->notifications->createForAllEligibleUsers([
                'type' => $validatedData['type'],
                'short_text' => $validatedData['short_text'],
                'expiration' => $validatedData['expiration']
            ]);
        } else {
            $this->notifications->create([
                'user_id' => $validatedData['user_id'],
                'type' => $validatedData['type'],
                'short_text' => $validatedData['short_text'],
                'expiration' => $validatedData['expiration']
            ]);
        }


        return redirect()->route('notifications.index')
            ->with('success', 'Notification posted successfully!');
    }

    /**
     * Mark a specific notification as read for the authenticated user.
     */
    public function markAsRead($id): JsonResponse
    {
        $success = $this->notifications->markAsRead($id, auth()->id());

        if (! $success) {
            abort(404);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(): RedirectResponse
    {
        $this->notifications->markAllAsRead(auth()->id());

        return redirect()->back()->with('success', 'All notifications marked as read!');
    }

    /**
     * Get the authenticated user's notifications.
     */
    public function getUserNotifications(): JsonResponse
    {
        $notifications = $this->notifications->getUserNotifications(auth()->id());

        return response()->json($notifications);
    }
}
