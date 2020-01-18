<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.01.20
 * Time: 11:38
 */
namespace App\JsonRPC;

use App\Exception\ServerException;
use Phalcon\Di;
use Phalcon\Http\Client\Request as ClientRequest;
use Phalcon\Http\Client\Response as ClientResponse;
use Datto\JsonRpc;

class Client
{
    const STATUS_OK = 200;

    /** @var string */
    private $clientUrl;

    /** @var string */
    private $serverUrl;

    public function __construct()
    {
        $config = Di::getDefault()->get('config');

        $this->clientUrl = $config->client->url;
        $this->serverUrl = $config->server->url;
    }

    /**
     * @param ClientResponse $response
     * @return string
     * @throws ServerException
     */
    public function prepareResponse(ClientResponse $response): string
    {
        if ($response->header->statusCode !== self::STATUS_OK) {
            throw new ServerException('Fatal error! Status code: ' . $response->header->statusCode);
        }

        if (!$response->body) {
            throw new ServerException('Fatal error! Body is empty');
        }

        try {
            $result = json_decode($response->body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ServerException('JSON exception: ' . $e->getMessage());
        }
        if (array_key_exists('error', $result)) {
            if (!is_array($result['error']) || !array_key_exists('message', $result['error'])) {
                throw new ServerException('Invalid response, not found section error.message');
            }
            throw new ServerException($result['error']['message']);
        }

        if (!array_key_exists('result', $result)) {
            throw new ServerException('Invalid response, not found section result');
        }

        if (!array_key_exists('message', $result['result'])) {
            throw new ServerException('Invalid response, not found section result.content');
        }

        return $result['result']['message'];
    }

    /**
     * @param $action
     * @param $data
     * @return string
     */
    public function prepareRequestBody($action, $data): string
    {
        $client = new JsonRpc\Client();
        $client->query(
            $id = $this->genId(),
            $action,
            $data
        );

        return $client->encode();
    }

    /**
     * @param string $body
     * @return ClientResponse
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function sendRequest(string $body): ClientResponse
    {
        $provider = ClientRequest::getProvider();
        $provider->setBaseUri($this->clientUrl);
        $provider->header->set('Accept', 'application/json');

        return $provider->post($this->serverUrl, $body);
    }

    /**
     * Generate unique ID for request
     * @return int
     */
    private function genId()
    {
        return time();
    }
}
