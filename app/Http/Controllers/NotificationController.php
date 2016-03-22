<?php

namespace App\Http\Controllers;

use App\Jobs\Notification\CreateNotificationCommand;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * Display Generator Page
     *
     * @param Notification $notification
     * @return $this
     */
    public function index(Notification $notification)
    {
        return view('notifications.index')->with('notifications', $notification->all());
    }

    /**
     * Display Generator Page
     *
     * @return $this
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Display Generator Page
     *
     * @param Request $request
     * @return $this
     */
    public function post(Request $request)
    {

        $command = new CreateNotificationCommand($request->all());
        $this->dispatch($command);

        return redirect()->route('notifications');
    }

}