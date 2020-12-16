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

        $user->logs()->create([
            'client_ip' => $this->argument('client_ip'),
            'client_port' => $this->argument('client_port'),
            'local_ip' => $this->argument('local_ip'),
            'remote_ip' => $this->argument('remote_ip'),
            'remote_port' => $this->argument('remote_port'),
            'bytes_received' => $this->argument('bytes_received'),
            'bytes_sent' => $this->argument('bytes_sent'),
        ]);

        $user->setOnline();
    }
}
