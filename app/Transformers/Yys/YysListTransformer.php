<?php

namespace App\Transformers\Yys;

use App\Transformers\BaseTransformer;

class YysListTransformer extends BaseTransformer
{
    public static function transform(array $list): array
    {
        return parent::transformItems($list, function ($item) {
            return self::listItem($item);
        });
    }

    public static function listItem($item)
    {
        return [
            'sn' => $item['game_ordersn'],
            'price' => round($item['price'] / 100),
            'nickname' => $item['format_equip_name'],
            'platform' => $item['platform_type'],
            'serverName' => $item['server_name'],
            'avalableTime' => $item['pass_fair_show'] ? time() : null
        ];
    }
}
