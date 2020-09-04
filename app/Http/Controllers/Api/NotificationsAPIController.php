<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications;
use Illuminate\Http\Request;

class NotificationsAPIController extends Controller
{
    public function index()
    {
        return Notifications::orderBy('id','DESC')->get();
    }
}
