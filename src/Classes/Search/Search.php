<?php


namespace faraamds\fias\Classes\Search;


use Illuminate\Support\Facades\DB;
use faraamds\fias\Models\AddressObject;

class Search
{
    /**
     * @param string $address
     * @return array
     */
    public static function byAddressString(string $address) : array
    {
        $keywords = preg_replace("/[\s,]+/", '|', $address);

        $result =  DB::select('SELECT * FROM fias_address_search(?)', [$keywords]);

        return array_map(function ($item) {

            return ["{$item->address} ({$item->actual_address})", $item->target_aoguid];

        }, $result);
    }

    /**
     * @param string $uuid
     * @return AddressObject
     */
    public static function byAoGuid(string $uuid): AddressObject
    {
        return AddressObject::where('aoguid', $uuid)->orderByDesc('enddate')->firstOrFail();
    }
}