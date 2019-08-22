<?php

use Phalcon\Config;

class UsersService
{
    private const JSON_RPC_VERSION = '2.0';

    /** @var Config $config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

  /**
   * @param string $username
   * @param string $password
   * @return array|null
   * @throws Exception
   */
    public function findUser(string $username, string $password): ?array
    {
        $res = null;

        $res = $this->request('usersService.findUser', [
            'username' => $username,
            'password' => hash('md5', $password),
        ]);

        return $res;
    }

  /**
   * @param string $method
   * @param array $params
   * @return array|null
   * @throws Exception
   */
    private function request(string $method, array $params = []): ?array
    {
        $request = [
            'jsonrpc' => self::JSON_RPC_VERSION,
            'method' => $method,
            'params' => $params,
            'id' => uniqid(),
        ];

        $request = json_encode($request);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->config->url,
            CURLOPT_HEADER => 0,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT_MS => 3000
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        $response_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response_http_code != 200) {
            throw new Exception(sprintf('Curl response http error code "%s"', $response_http_code));
        }

        curl_close($ch);

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            $message = $response['error']['message'];
            $code = $response['error']['code'];
            throw new Exception($message, $code);
        }

        return $response['result'];
    }
}