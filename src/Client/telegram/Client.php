<?php


namespace App\Client\telegram;


class Client
{

    public const METHOD_SEND_MESSAGE = 'sendMessage';
    public const METHOD_GET_UPDATES = 'getUpdates';
    private const BASE_DOMAIN = 'https://api.telegram.org/bot';
    protected $token = '';


    public function getUpdates(): array
    {
        return $this->runMethod(self::METHOD_GET_UPDATES);
    }


    public function sendMessage(array $params): array
    {
        return $this->runMethod(self::METHOD_SEND_MESSAGE, $params);
    }

    public function runMethod(string $method, array $params = []): array
    {
        if (empty($params)) {
            $url = self::BASE_DOMAIN . $this->token . '/' . $method;
        } else {
            $url = self::BASE_DOMAIN . $this->token . '/' . $method . '?' . http_build_query($params);

        }
        return json_decode(file_get_contents($url), TRUE);
    }


    public function setToken(string $token): Client
    {
        $this->token = $token;
        return $this;
    }


}