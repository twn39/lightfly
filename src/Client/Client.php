<?php
/**
 * Created by human.
 * User: Weinan Tang <twn39@163.com>
 * Date: 2019-04-26
 * Time: 14:01
 */
namespace App\Client;

class Client
{
    private $keyId;

    private $algorithm = "hmac-sha256";

    private $headers;

    private $signature;

    private $httpClient;

    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function setKeyId($id)
    {
        $this->keyId = $id;
    }



    public function request($url, $method, $body)
    {
        $keyId = $this->keyId;
        $algorithm = $this->algorithm;
        $headers = $this->getHeaders();
        $signature = $this->getSignature();

        $token = "Signature keyId=\"$keyId\",algorithm=\"$algorithm\",headers=\"$headers\",signature=\"$signature\"";

        $response = Http::request($url, $method, $body, Http::JSON, [
            'Authorization' => $token,
        ]);

        $response = json_decode($response, true);
        if (isset($response['error'])) {
            throw new \Exception($response['message'], $response['code']);
        }

        return $response;
    }

    /**
     * @param string $algorithm
     */
    public function setAlgorithm(string $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }
}