<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:40 PM
 * Blog lurrpis.com
 */

namespace GMCloud\SDK;

use Exception;

class Yunbi extends Client
{
    public static $apiUri = 'https://yunbi.com';

    public static function membersMe()
    {
        $uri = '/api/v2/members/me';

        return self::get($uri);
    }

    public static function markets()
    {
        $uri = '/api/v2/markets';

        return self::get($uri);
    }

    public static function tickers($market = '')
    {
        static::$sign = false;

        $uri = $market ? '/api/v2/tickers/' . $market : '/api/v2/tickers';

        return self::get($uri);
    }

    public static function depositAddress($currency)
    {
        $uri = '/api/v2/deposit_address';

        $params = [
            'currency' => $currency
        ];

        return self::get($uri, $params);
    }

    public static function deposit($txid)
    {
        $uri = '/api/v2/deposit';

        $params = [
            'txid' => $txid
        ];

        return self::get($uri, $params);
    }

    public static function deposits($currency = '', $limit = '', $state = '')
    {
        $uri = '/api/v2/deposits';

        $params = [];

        $currency && $params['currency'] = $currency;
        $limit && $params['limit'] = $limit;
        $state && $params['state'] = $state;

        return self::get($uri, $params);
    }

    public static function depth($market, $limit = '')
    {
        $uri = '/api/v2/depth';

        $params = [
            'market' => $market
        ];

        $limit && $params['limit'] = $limit;

        return self::get($uri, $params);
    }

    public static function order($id)
    {
        $uri = '/api/v2/order';

        $params = [
            'id' => $id
        ];

        return self::get($uri, $params);
    }

    public static function deleteOrder($id)
    {
        $uri = '/api/v2/order/delete';

        $params = [
            'id' => $id
        ];

        return self::post($uri, $params);
    }

    public static function orders($market, $state = '', $limit = '', $page = '', $orderBy = '')
    {
        $uri = '/api/v2/orders';

        $params = [
            'market' => $market
        ];

        $state && $params['state'] = $state;
        $limit && $params['limit'] = $limit;
        $page && $params['page'] = $page;
        $orderBy && $params['orderBy'] = $orderBy;

        return self::get($uri, $params);
    }

    public static function createOrder($market, $side, $volume, $price = '', $orderType = '')
    {
        $uri = '/api/v2/orders';

        $params = [
            'market' => $market,
            'side'   => $side,
            'volume' => $volume
        ];

        $price && $params['price'] = $price;
        $orderType && $params['orderType'] = $orderType;

        return self::post($uri, $params);
    }

    public static function createOrderMulti($market, $orders)
    {
        $uri = '/api/v2/orders/multi';

        if (!isset($orders['side']) || !isset($orders['volume'])) {
            throw new Exception('Invalided params');
        }

        $params = [
            'market' => $market,
            'orders' => $orders
        ];

        return self::post($uri, $params);
    }

    public static function clearOrders($side = '')
    {
        $uri = '/api/v2/orders/clear';

        $params = [];

        $side && $params['side'] = $side;

        return self::post($uri, $params);
    }

    public static function trades($market, $limit = '', $timestamp = '', $from = '', $to = '', $orderBy = '')
    {
        $uri = '/api/v2/trades';

        $params = [
            'market' => $market,
        ];

        $limit && $params['limit'] = $limit;
        $timestamp && $params['timestamp'] = $timestamp;
        $from && $params['from'] = $from;
        $to && $params['to'] = $to;
        $orderBy && $params['orderBy'] = $orderBy;

        return self::get($uri, $params);
    }

    public static function myTrades($market, $limit = '', $timestamp = '', $from = '', $to = '', $orderBy = '')
    {
        $uri = '/api/v2/trades/my';

        $params = [
            'market' => $market,
        ];

        $limit && $params['limit'] = $limit;
        $timestamp && $params['timestamp'] = $timestamp;
        $from && $params['from'] = $from;
        $to && $params['to'] = $to;
        $orderBy && $params['orderBy'] = $orderBy;

        return self::get($uri, $params);
    }

    public static function orderBook($market, $asksLimit = '', $bidsLimit = '')
    {
        $uri = '/api/v2/order_book';

        $params = [
            'market' => $market,
        ];

        $asksLimit && $params['asksLimit'] = $asksLimit;
        $bidsLimit && $params['bidsLimit'] = $bidsLimit;

        return self::get($uri, $params);
    }

    public static function timestamp()
    {
        $uri = '/api/v2/timestamp';

        return self::get($uri);
    }

    public static function addresses($address)
    {
        $uri = '/api/v2/addresses/' . $address;

        return self::get($uri);
    }

    public static function kLine($market, $limit = '', $period = '', $timestamp = '')
    {
        $uri = '/api/v2/k';

        $params = [
            'market' => $market,
        ];

        $limit && $params['limit'] = $limit;
        $period && $params['period'] = $period;
        $timestamp && $params['timestamp'] = $timestamp;

        return self::get($uri, $params);
    }

    public static function kWithPendingTrades($market, $tradeId, $limit = '', $period = '', $timestamp = '')
    {
        $uri = '/api/v2/k_with_pending_trades';

        $params = [
            'market'   => $market,
            'trade_id' => $tradeId
        ];

        $limit && $params['limit'] = $limit;
        $period && $params['period'] = $period;
        $timestamp && $params['timestamp'] = $timestamp;

        return self::get($uri, $params);
    }

    public static function orderTrade($id, $accessKeyHash)
    {
        $uri = '/api/v2/partners/orders/' . $id . '/trades';

        $params = [
            'access_key_hash' => $accessKeyHash
        ];

        return self::get($uri, $params);
    }
}