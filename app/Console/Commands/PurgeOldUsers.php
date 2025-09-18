<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class PurgeOldUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-old-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete user deactivated for more than 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limetDate = Carbon::now()->subDays(30);

        $user = User::onlyTrashed()
            ->where('deleted_at', '<=', $limetDate)
            ->get();

        foreach ($users as $user) {
            $user->forceDelete();
        }

        $this->info(count($users) . ' users permanently deleted.');
    }
}
