<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\NotificationController;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notificationController = new NotificationController();
        $notification = $notificationController->listNotification();
        return view('admin.dashboard', compact('notification'));
    }
}
