<?php

namespace App\Console\Commands;

use App\Models\NotificationArchive;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class DeleteOldNotifications extends Command
{
    // run scheduler 
    // * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astek:delete-old-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive and delete notifications older than 3 weeks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeWeeksAgo = Carbon::now()->subWeeks(3);

        $oldNotifications = DatabaseNotification::where('created_at', '<', $threeWeeksAgo)->get();

        if ($oldNotifications->isEmpty()) {
            $this->info('No old notifications to archive or delete.');
            return;
        }

        foreach ($oldNotifications as $notification) {
            NotificationArchive::create([
                'type' => $notification->type,
                'data' => $notification->data,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,
            ]);
        }

        DatabaseNotification::where('created_at', '<', $threeWeeksAgo)->delete();

        $this->info('Old notifications archived and deleted successfully.');
    }
}
