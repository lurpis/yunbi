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
    public static $timeout = 3;

    protected static $sign = true;
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

    protected static function queryBuild($params)
    {
        ksort($params);

        if(isset($params['orders'])) {
            foreach ($params['orders'] as &$order) {
                ksort($order);
            }
        }

        return urldecode(preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', http_build_query($params)));
    }

    protected static function signature($uri, $method, $params)
    {
        $query = static::queryBuild($params);

        return hash_hmac('sha256', implode('|', [$method, $uri, $query]), static::$secretKey);
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

            if (static::$sign) {
                $params['signature'] = static::signature($uri, $method, $params);
            }

            $response = $client->request($method, $uri, [RequestOptions::QUERY => static::queryBuild($params)]);
            $data = $response->getBody()->getContents();

            return json_decode($data, true);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}