<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    // Lấy ra tất cả thông báo
    public function getAllNotifications()
    {
        return Notification::all();
    }

    // Lấy ra thông báo theo ID
    public function getNotificationById($id)
    {
        return Notification::find($id);
    }

    // Lấy ra thông báo theo user_id
    public function getNotificationsByUserId($userId)
    {
        return Notification::where('user_id', $userId)->get();
    }

    // Tạo thông báo mới
    public function createNotification(array $data)
    {
        return Notification::create($data);
    }

    // Cập nhật thông báo
    public function updateNotification($id, array $data)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update($data);
        }
        return $notification;
    }

    // Xóa thông báo
    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            return $notification->delete();
        }
        return false;
    }

    // Đánh dấu thông báo là đã đọc
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->is_read = !$notification->is_read;
            $notification->save();
        }
        return $notification;
    }
}
