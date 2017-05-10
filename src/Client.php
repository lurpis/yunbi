<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:40 PM
 * Blog lurrpis.com
 */

namespace GMCloud\SDK;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class Client
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    public static $apiUri;
    public static $contentType = 'application/json';
    public static $header = [];
    public static $timeout = 1;

    protected static $accessKey;
    protected static $secretKey;

    public static function instance()
    {
        if (empty(static::$accessKey) || empty(static::$secretKey)) {
            throw new Exception('lost access key or secret key');
        }

        if (empty(static::$apiUri)) {
            throw new Exception('lost api url');
        }

        $headers = static::$header + [
                'Content-Type' => static::$contentType,
                'Accept'       => static::$contentType,
            ];

        return new HttpClient([
            'base_uri' => static::$apiUri,
            'timeout'  => static::$timeout,
            'headers'  => $headers
        ]);
    }

    public static function setAccessKey($accessKey)
    {
        return static::$accessKey = $accessKey;
    }

    public static function setSecretKey($secretKey)
    {
        return static::$secretKey = $secretKey;
    }

    protected static function signature($uri, $method, $params)
    {
        ksort($params);

        return hash_hmac('sha256', implode('|', [$method, $uri, http_build_query($params)]), static::$secretKey);
    }

    public static function get($uri, $params = [])
    {
        return static::send($uri, self::GET, $params);
    }

    public static function post($uri, $params = [])
    {
        return static::send($uri, self::POST, $params);
    }

    public static function put($uri, $params = [])
    {
        return static::send($uri, self::PUT, $params);
    }

    public static function delete($uri, $params = [])
    {
        return static::send($uri, self::DELETE, $params);
    }

    public static function send($uri, $method, $params)
    {
        $client = static::instance();

        try {
            $params += [
                'access_key' => static::$accessKey,
                'tonce'      => round(microtime(true) * 1000)
            ];

            $params['signature'] = static::signature($uri, $method, $params);

            $response = $client->request($method, $uri, [RequestOptions::FORM_PARAMS => $params]);
            $data = $response->getBody()->getContents();

            return json_decode($data, true);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}