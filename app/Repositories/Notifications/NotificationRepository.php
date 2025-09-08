<?php

namespace App\Repositories\Notifications;

use App\Models\Notification;
use App\Repositories\Users\UserInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NotificationRepository implements NotificationInterface
{
    public function getAllNotificationsWithFilters(?string $type, ?int $userId, int $perPage = 15): LengthAwarePaginator
    {
        $query = Notification::with('user')->latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function createForAllEligibleUsers(array $data): void
    {
        $users = app(UserInterface::class)->getEligibleForNotifications();

        foreach ($users as $user) {
            Notification::create([
                'user_id'    => $user->id,
                'type'       => $data['type'],
                'short_text' => $data['short_text'],
                'expiration' => $data['expiration'],
            ]);
        }
    }

    public function markAsRead(int $id, int $userId): bool
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (! $notification) {
            return false;
        }

        return $notification->update(['is_read' => true]);
    }

    public function markAllAsRead(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function getUserNotifications(int $userId, int $limit = 10): Collection
    {
        return Notification::where('user_id', $userId)
            ->active()
            ->latest()
            ->take($limit)
            ->get();
    }
}
