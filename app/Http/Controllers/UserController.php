<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //  trả về tất cả người dùng  
    public function index()
    {
        try {
            $users = $this->userService->listAllUsers();
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $this->userService->createUser($request->all());
            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->all());
            return response()->json([
               'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }

    public function destroy($id)    {
        try {
            $this->userService->deleteUser($id);
            return response()->json([
              'success' => true,
              'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
              'success' => false,
              'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }
}
