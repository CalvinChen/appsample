<?php

namespace App\Services;

use App\Transformers\Yys\YysListTransformer;
use App\Transformers\Yys\YysAccountTransformer;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Boolean;

class YysClient
{
    protected $apiUrl = 'https://recommd.yys.cbg.163.com/cgi-bin/recommend.py';

    public function getAccountList(array $params = [])
    {
        $query = [
            'act' => 'recommd_by_role',
            'search_type' => 'role',
            'count' => '15',
            'order_by' => 'price ASC',
            'strength' => '50000',
            'platform_type' => '2',
            'pass_fair_show' => 1,
            'page' => 1,
            '_t' => time() . rand(100, 999),
        ];

        $json = Http::withOptions(['verify' => false])
            ->get($this->apiUrl, $query)->json();

        return YysListTransformer::transform($json['result']);
    }

    public function getAccountDetail(string $sn): array
    {
        $query = [
            'serverid' => explode('-', $sn)[1],
            'ordersn' => $sn,
            'view_loc' => 'search|tag_key:{"sort_key": "price", "tag": "user", "sort_order": "ASC", "extern_tag": null}',
        ];

        $json = Http::withOptions(['verify' => false])
            ->asForm()
            ->post('https://yys.cbg.163.com/cgi/api/get_equip_detail', $query)->json();

        return YysAccountTransformer::transform($json['equip']);
    }
}
