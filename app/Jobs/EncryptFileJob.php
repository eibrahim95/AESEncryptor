<?php

namespace App\Jobs;

use App\Lib\Encryptor\EncryptorInterface;
use App\Models\UserFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EncryptFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param UserFile $file
     */
    public function __construct(UserFile $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @param EncryptorInterface $encryptor
     * @return void
     */
    public function handle(EncryptorInterface $encryptor)
    {
        $this->file->update(['status'=>'running']);
        $outputFile = $encryptor->encrypt($this->file->path);
        $this->file->update(['output_path'=>$outputFile]);
    }
    public function setJobSuccess(){
        $this->file->update(['status'=>'success']);
    }
    public function setJobFailed(){
        $this->file->update(['status'=>'failed']);
    }
}
