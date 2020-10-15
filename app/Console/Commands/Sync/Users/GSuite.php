<?php

namespace App\Console\Commands\Sync\Users;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use App\Libs\Providers\GSuite as Provider;

class GSuite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users:gsuite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users that are no longer in GSUite';

    /**
     * GSuite Provider.
     *
     * @var Provider
     */
    protected $provider;

    /**
     * @var array
     */
    private $authorisedEmails = [];

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle()
    {
        $json = getenv('GSUITE_JSON');
        if (!$json) {
            $this->error('JSON is empty, exiting...');
            return;
        }
        $this->provider = new Provider(getenv('AUTH_DOMAIN'), json_decode($json, true));

        if (!$this->provider->auth()) {
            $this->requestAuthCode();
            if (!$this->provider->auth()) {
                $this->error('Auth failed');
                return;
            }
        }

        $this->loadAuthorisedEmails();
        if (empty($this->authorisedEmails)) {
            $this->error('No users received from GSuite, exiting...');
            return;
        } else {
            $this->info(count($this->authorisedEmails) . ' users received from GSuite...');
        }

        foreach (User::all() as $user) {
            if (!$this->isAuthorised($user)) {
                $this->line('Deleting ' . $user->email . '...');
                $user->delete();
            }
        }

        // OpenVPN reload
    }

    /**
     * Request the auth code to the user.
     *
     * @throws Exception
     */
    private function requestAuthCode()
    {
        $this->info('Navigate to: ' . $this->provider->generateAuthUrl());
        $authCode = $this->secret('Auth code: ');
        $this->provider->generateTokenFromAuthCode($authCode);
    }

    /**
     * Load the authorised emails from the provider.
     */
    private function loadAuthorisedEmails()
    {
        foreach ($this->provider->getUsers() as $item) {
            $this->authorisedEmails[] = $item->getPrimaryEmail();
        }
    }

    /**
     * Check if an user is authorised.
     *
     * @param  User $user
     * @return bool
     */
    private function isAuthorised(User $user)
    {
        return in_array($user->email, $this->authorisedEmails);
    }
}
