<?php

namespace App\Libs\Providers;

use Google_Client;
use Google_Exception;
use Google_Service_Directory;
use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * GSuite Provider.
 */
class GSuite
{
    /**
     * GSuite Domain.
     *
     * @var string
     */
    private $domain;

    /**
     * Access Token (JSON)
     *
     * @var string
     */
    private $token;

    /**
     * Google Client.
     *
     * @var Google_Client
     */
    private $client;

    /**
     * Cache key to store the token.
     *
     * @var string
     */
    const CACHE_TOKEN = 'GSUITE_TOKEN';

    /**
     * Initialises the Github Client.
     *
     * @param string $domain
     * @param array $credentials
     * @throws Google_Exception
     */
    public function __construct(string $domain, array $credentials)
    {
        $this->domain = $domain;
        $this->setClient($credentials);
    }

    /**
     * Initialises the Google Client.
     *
     * @param array $credentials
     * @throws Google_Exception
     */
    private function setClient(array $credentials)
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig($credentials);
        $this->client->setScopes([
            Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY,
        ]);
        $this->client->setAccessType('offline');
    }

    /**
     * Authenticates the client with the token.
     *
     * @return bool
     */
    public function auth()
    {
        $token = $this->getToken();
        if (!$token) {
            return false;
        }
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            if (!$this->client->getRefreshToken()) {
                return false;
            }
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $this->setToken($this->client->getAccessToken());
        }

        return true;
    }

    /**
     * Get the token from cache.
     *
     * @return array|null
     */
    private function getToken()
    {
        $token = Cache::get(self::CACHE_TOKEN);
        if ($token) {
            return json_decode($token, true);
        }
    }

    /**
     * Store the token in cache.
     *
     * @param array $token
     * @return bool
     */
    private function setToken(array $token)
    {
        return Cache::set(self::CACHE_TOKEN, json_encode($token));
    }

    /**
     * Generate the GSuite Auth URL to generate an Auth Code.
     *
     * @return string
     */
    public function generateAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Generates a new Access Token using an obtained Auth Code.
     *
     * @param string $authCode
     * @throws Exception Error
     * @return bool
     */
    public function generateTokenFromAuthCode(string $authCode)
    {
        // Exchange authorization code for an access token.
        $token = $this->client->fetchAccessTokenWithAuthCode($authCode);
        if (array_key_exists('error', $token)) {
            throw new Exception(join(', ', $token));
        }

        $this->setToken($token);

        return true;
    }

    /**
     * Get all GSuite users.
     *
     * @throws Exception
     * @return array
     */
    public function getUsers()
    {
        $service = new Google_Service_Directory($this->client);

        $results = $service->users->listUsers(['domain' => $this->domain]);
        $result = [];
        foreach ($results->getUsers() as $user) {
            $result[] = $user;
        }

        return $result;
    }
}
