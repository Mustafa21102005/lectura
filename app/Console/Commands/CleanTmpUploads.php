<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanTmpUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploads:clean-tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old temporary uploaded files safely';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('public');
        $tmpPath = 'uploads/tmp';

        if (!$disk->exists($tmpPath)) {
            $this->info('No tmp directory found.');
            return 0;
        }

        $directories = $disk->directories($tmpPath);
        $now = Carbon::now();
        $deleted = 0;

        foreach ($directories as $dir) {
            $lastModified = Carbon::createFromTimestamp($disk->lastModified($dir));

            // Only delete folders older than 3 minutes
            if ($lastModified->diffInMinutes($now) > 3) {
                $disk->deleteDirectory($dir);
                $deleted++;
                $this->info("Deleted old tmp folder: {$dir}");
            }
        }

        if ($deleted === 0) {
            $this->info('No old folders to delete.');
        }

        return 0;
    }
}
