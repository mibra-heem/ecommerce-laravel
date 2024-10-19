<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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
    try {
        $name = $this->ask('What is the name of the user?');
        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What is the password for the user?');
        $role = $this->choice('What is the role of the user?', ['admin', 'user'], 1);

        $this->info("Creating user with name: $name, email: $email, role: $role");

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role
        ]);

        $this->info('User created successfully!');
    } catch (\Exception $e) {
        $this->error('An error occurred: ' . $e->getMessage());
    }

    return 0;
}
	
}
