<?php

namespace App\Console\Commands\OpenVPN;

use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;

class Login extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openvpn:login {user} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'OpenVPN authentication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Auth::attempt([
            'email' => $this->argument('user'),
            'password' => $this->argument('password')
            ])) {
            echo 'ok';
        } else {
            echo 'ko';
        }
    }
}
