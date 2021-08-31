<?php

namespace App\Listeners;

use App\Jobs\DecryptFileJob;
use App\Jobs\EncryptFileJob;
use Illuminate\Queue\Events\JobProcessed;

class MarkJobProcessed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobProcessed  $event
     * @return void
     */
    public function handle(JobProcessed $event)
    {
        $class = $event->job->resolveName();
        if ($class = EncryptFileJob::class || $class == DecryptFileJob::class) {
            $payload = $event->job->payload();
            $myJob = unserialize($payload['data']['command']);
            $myJob->setJobSuccess();
        }
    }
}
