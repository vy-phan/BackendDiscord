<?php

namespace App\Repositories\Interfaces;

interface NotificationRepositoryInterface
{
    // Lấy ra tất cả thông báo
    public function getAllNotifications();
    // Lấy ra thông báo theo ID
    public function getNotificationById($id);
    // Lấy ra thông báo theo user_id
    public function getNotificationsByUserId($userId);
    // tạo thông báo mới
    public function createNotification(array $data);
    // Cập nhật thông báo
    public function updateNotification($id, array $data);
    // Xóa thông báo
    public function deleteNotification($id);
    // Đánh dấu thông báo là đã đọc
    public function markAsRead($id);
}