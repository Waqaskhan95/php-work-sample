<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AddUserRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will add the users roles for the old data';

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
    public function handle() {
        
        $users = User::where('role_id','!=',1)->get();
        foreach ($users as $key => $user) {
            $role = Role::find($user->role_id);
            $user->assignRole($role);
        }

        return true;
    }
}
