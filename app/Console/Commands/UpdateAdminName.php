<?php

namespace App\Console\Commands;

use App\Library\Eeyes\Api\XjtuUserInfo;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Console\Command;

class UpdateAdminName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:name:update {username?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update specified admin user name.';

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
     * @return mixed
     */
    public function handle()
    {
        $usernames = $this->argument('username');
        if ($usernames) {
            foreach ($usernames as $username) {
                $user = update_admin_name($username);
                if ($user) {
                    $this->info("Update {$username}'s name to {$user->name}.");
                } else {
                    $this->error("Update {$username} error.");
                };
            }
        } else {
            $usernames = Administrator::pluck('username')->toArray();
            while ($username = $this->choice('Update which user (Ctrl-C to exit)', $usernames)) {
                $user = update_admin_name($username);
                if ($user) {
                    $this->info("Update {$username}'s name to {$user->name}.");
                } else {
                    $this->error("Update {$username} error.");
                };
            }
        }
    }
}
