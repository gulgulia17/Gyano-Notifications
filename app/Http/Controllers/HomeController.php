<?php

namespace App\Http\Controllers;

use App\Notifications;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function notification(Request $request)
    {
        Notifications::create($request->validate([
            "notificationtitle"     => 'required|string',
            "notificationdesscript" => 'required|string|max:100',
        ]));
        $this->SendFCM($request);
        return back()->with('status', 'Notification sent successfully.');
    }

    protected function SendFCM($request)
    {
        $token = "/topics/all";
        $url = env('FIREBASE_URL');
        $serverKey = env('FIREBASE_TOKEN');
        $title = $request->notificationtitle;
        $message = $request->notificationdesscript;
        $notification = array('title' => $title, 'body' => $message, 'sound' => 'true', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
            var_dump(curl_error($ch));
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
