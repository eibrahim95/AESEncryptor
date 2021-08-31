<?php

namespace App\Console\Commands;

use App\Models\UserFile;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class GarbageCollectFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garbage:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete User files that were updated over one hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_files = UserFile::whereTime('updated_at', '<', Carbon::now()->subHour());
        Storage::disk('public')->delete(...$user_files->pluck('path'));
        Storage::disk('public')->delete(...$user_files->pluck('output_path'));
        $user_files->delete();
        return 0;
    }
}
