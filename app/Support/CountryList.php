<?php

namespace App\Support;

class CountryList
{
    public static function get(): array
    {
        $list = [];

        foreach (\Annexare\Countries\countries() as $code => $data) {
            $list[$code] = $data['name'];
        }

        asort($list);

        return $list;
    }
}
