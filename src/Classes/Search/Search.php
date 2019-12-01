<?php


namespace faraamds\fias\Classes\Search;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use faraamds\fias\Models\AddressObject;

class Search
{
    const HOUSE_SUBSTRINGS = ['дом', 'д'];
    const APARTMENT_SUBSTRINGS = ['кв', 'квартира'];

    /**
     * @param string $address
     * @return array
     */
    public static function byAddressString(string $address) : array
    {
//        $keywords = preg_replace("/[\s,]+/", '|', $address);

        $converter = new SearchObject($address);

        $result =  DB::select('SELECT * FROM fias_address_search(?)', [$converter->getKeywords()]);

        return array_map(function ($item) {

            return ["{$item->address} ({$item->actual_address})", $item->target_aoguid, $item->target_aoid];

        }, $result);
    }

    public static function byAddress(string $address, string $house = null, string $building = null, string $structure = null, string $apartment = null, string $region = null)
    {
        $best_candidate = null;
        $addresses = DB::select('SELECT * FROM fias_address_search(?, ?)', [static::createTsQuery($address), $region]);

        $best = Arr::first($addresses);

        if ($best) {
            $best_candidate = (new SearchAddressResult())->fill($best->aoguid, $house, $building, $structure, $apartment)->toJson();
        }

        return compact('addresses', 'best_candidate');
    }

    /**
     * @param string $uuid
     * @return AddressObject
     */
    public static function byAoGuid(string $uuid): AddressObject
    {
        return AddressObject::where('aoguid', $uuid)->orderByDesc('enddate')->firstOrFail();
    }

    /**
     * @param string $query
     * @return string
     */
    protected static function createTsQuery(string $query) : string
    {
        return $query;
//        return preg_replace('/\s+/', ' & ', trim($query));
//        $keywords = preg_split('/\s*,\s*/', $query);
//
//        return implode(' | ', array_map(function ($item) {
//
//            return preg_replace('/\s+/', ' & ', trim($item));
//
//        }, $keywords));
    }
}
