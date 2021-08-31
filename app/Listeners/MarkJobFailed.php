<?php

namespace App\Listeners;

use App\Jobs\DecryptFileJob;
use App\Jobs\EncryptFileJob;
use Illuminate\Queue\Events\JobFailed;

class MarkJobFailed
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
     * @param  JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        $class = $event->job->resolveName();
        if ($class = EncryptFileJob::class || $class == DecryptFileJob::class) {
            $payload = $event->job->payload();
            $myJob = unserialize($payload['data']['command']);
            $myJob->setJobFailed();
        }
    }
}
