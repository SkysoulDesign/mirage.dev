<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class CreateNotificationCommand
{

    /**
     * @var Collection
     */
    private $request;

    /**
     * Create a new job instance.
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = collect($request);
    }

    /**
     * Execute the job.
     *
     * @param Notification $notification
     * @return Collection
     */
    public function handle(Notification $notification)
    {
        $notification->create($this->request->toArray());
    }

}
