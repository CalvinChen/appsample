<?php

namespace App\Repositories;

use App\Models\YysAccount;
use Illuminate\Database\Eloquent\Collection;

class YysAccountRepository
{
    public static function new(): YysAccount
    {
        return new YysAccount();
    }

    public static function get(string $sn): ?YysAccount
    {
        $account = YysAccount::where('sn', '=', $sn)->first();

        return $account;
    }

    public static function getAll(array $config = [])
    {
        $builder = YysAccount::query();
        if (isset($config['orderBy'])) {
            $builder->orderBy($config['orderBy'][0], $config['orderBy'][1]);
        }
        // if (isset($config['groupBy'])) {
        //     $builder->groupBy($config['groupBy']);
        // }

        return $builder->paginate(20);
    }

    public static function getRanking()
    {
        $accounts = YysAccount::orderBy('yuhunScore', 'desc')->limit(100)->get();

        return $accounts->unique('roleId')->take(50);
    }

    public static function save(array $data): YysAccount
    {
        $account = YysAccount::firstOrNew(['sn' => $data['sn']]);
        $account->fill($data);
        $account->save();

        return $account;
    }

    public static function getUnupdated(): ?YysAccount
    {
        return YysAccount::whereNeedUpdate()->first();
    }
}
