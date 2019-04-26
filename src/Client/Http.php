<?php
/**
 * Created by human.
 * User: Weinan Tang <twn39@163.com>
 * Date: 2018/11/20
 * Time: 下午12:12
 */
namespace App\Client;

class Http
{

    static $instance = null;

    const JSON = 'json';
    const XML  = 'xml';
    const FORM = 'form';
    const RAW  = 'raw';
    const HTML = 'html';

    private $contentTypeMap;

    private function __construct()
    {
        $this->contentTypeMap = [
            self::JSON => "application/json;charset=UTF-8",
            self::XML  => "text/xml",
            self::FORM => "application/x-www-form-urlencoded",
            self::RAW  => "text/plain",
            self::HTML => "text/html",
        ];
    }

    /**
     * @param        $url
     * @param        $method
     * @param        $bodyParams
     * @param string $type
     * @param        $headers
     *
     * @return bool|string
     */
    private function request($url, $method, $bodyParams, $type = 'form', $headers = [])
    {
        $headers['Content-type'] = $this->contentTypeMap[$type];

        $headContent = [];
        foreach ($headers as $key => $value) {
            $headContent[] = "$key:$value\r\n";
        }
        $headerString = implode('', $headContent);

        $body = is_array($bodyParams)
            ? http_build_query($bodyParams)
            : $bodyParams;

        $option = [
            'http' => [
                'method'  => $method,
                'header'  => $headerString,
                'content' => $body,
                'follow_location' => 0,
                'timeout' => 30.0,
                'ignore_errors' => true,
            ],
        ];
        $context = stream_context_create($option);

        return file_get_contents($url, false, $context);
    }

    /**
     * @param        $url
     * @param        $queryParams
     * @param string $type
     * @param array  $headers
     *
     * @return bool|string
     */
    private function get($url, $queryParams, $type = 'raw', $headers = [])
    {
        $queryString = http_build_query($queryParams);

        return $this->request("$url?$queryString", 'GET', '', $type, $headers);
    }

    /**
     * @param        $url
     * @param        $queryParams
     * @param string $type
     * @param array  $headers
     *
     * @return bool|string
     */
    private function post($url, $queryParams, $type = 'form', $headers = [])
    {
        return $this->request($url, 'POST', $queryParams, $type, $headers);
    }

    /**
     * @param        $url
     * @param        $queryParams
     * @param string $type
     * @param array  $headers
     *
     * @return bool|string
     */
    private function put($url, $queryParams, $type = 'form', $headers = [])
    {
        return $this->request($url, 'PUT', $queryParams, $type, $headers);
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = self::$instance;
        if (is_null(self::$instance)) {
            $instance = new self();
        }

        return $instance->$name(...$arguments);
    }

}
