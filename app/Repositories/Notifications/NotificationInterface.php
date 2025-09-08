<?php

namespace App\Repositories\Notifications;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface NotificationInterface
{
    public function getAllNotificationsWithFilters(?string $type, ?int $userId, int $perPage = 15): LengthAwarePaginator;

    public function create(array $data);

    public function createForAllEligibleUsers(array $data): void;

    public function markAsRead(int $id, int $userId): bool;

    public function markAllAsRead(int $userId): int;

    public function getUserNotifications(int $userId, int $limit = 10): Collection;
}
