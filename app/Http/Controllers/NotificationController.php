<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Lấy tất cả thông báo
    public function index()
    {
        $notifications = $this->notificationService->listAllNotifications();
        return response()->json($notifications);
    }

    // Lấy thông báo theo ID
    public function show($id)
    {
        $notification = $this->notificationService->getNotificationById($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json($notification);
    }

    // Lấy thông báo theo user_id
    public function getByUserId($userId)
    {
        $notifications = $this->notificationService->getNotificationsByUserId($userId);
        return response()->json($notifications);
    }

    // Tạo mới thông báo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:50',
            'content' => 'required|string',
        ]);

        $notification = $this->notificationService->createNotification($validated);

        return response()->json($notification, 201);
    }

    // Cập nhật thông báo
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'sometimes|string|max:50',
            'content' => 'sometimes|string',
            'is_read' => 'sometimes|boolean',
        ]);

        $notification = $this->notificationService->updateNotification($id, $validated);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json($notification);
    }

    // Xóa thông báo
    public function destroy($id)
    {
        $deleted = $this->notificationService->deleteNotification($id);

        if (!$deleted) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json(['message' => 'Deleted successfully']);
    }

    // Đánh dấu đã đọc
    public function markAsRead($id)
    {
        $notification = $this->notificationService->markAsRead($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json(['message' => 'Notification marked as read', 'data' => $notification]);
    }
}
