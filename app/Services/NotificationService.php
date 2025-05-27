<?php

namespace App\Services;

use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function listAllNotifications()
    {
        return $this->notificationRepository->getAllNotifications();
    }

    public function getNotificationById($id)
    {
        return $this->notificationRepository->getNotificationById($id);
    }

    public function getNotificationsByUserId($userId)
    {
        return $this->notificationRepository->getNotificationsByUserId($userId);
    }

    public function createNotification(array $data)
    {
        return $this->notificationRepository->createNotification($data);
    }

    public function updateNotification($id, array $data)
    {
        return $this->notificationRepository->updateNotification($id, $data);
    }

    public function deleteNotification($id)
    {
        return $this->notificationRepository->deleteNotification($id);
    }

    public function markAsRead($id)
    {
        return $this->notificationRepository->markAsRead($id);
    }
}
