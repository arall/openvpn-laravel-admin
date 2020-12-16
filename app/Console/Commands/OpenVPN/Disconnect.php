<?php

namespace App\Console\Commands\OpenVPN;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Disconnect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openvpn:disconnect {user} {remote_ip} {bytes_received=0} {bytes_sent=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers an OpenVPN disconnection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('user'))->firstOrFail();

        $log = $user->logs()->where('remote_ip', $this->argument('remote_ip'))->whereNull('end_time')->firstOrFail();
        $log->bytes_received = $this->argument('bytes_received');
        $log->bytes_sent = $this->argument('bytes_sent');
        $log->end_time = Carbon::now();
        $log->save();

        if ($user->logs()->whereNull('end_time')->doesntExist()) {
            $user->setOffline();
        }
    }
}
