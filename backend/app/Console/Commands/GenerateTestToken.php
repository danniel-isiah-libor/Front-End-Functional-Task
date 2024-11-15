<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateTestToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a test token for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::factory()->create();

        $token = $user->createToken($user->email)->plainTextToken;

        $this->info($token);
    }
}
