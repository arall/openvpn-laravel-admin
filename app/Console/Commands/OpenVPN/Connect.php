<?php

namespace App\Console\Commands\OpenVPN;

use App\Models\User;
use Illuminate\Console\Command;

class Connect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openvpn:connect {user} {client_ip} {client_port} {local_ip} {remote_ip} {remote_port} {bytes_received=0} {bytes_sent=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers an OpenVPN connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('user'))->firstOrFail();



        $user->setOffline();
    }
}
