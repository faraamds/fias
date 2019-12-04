<?php


namespace faraamds\fias\Classes\Search;


use Illuminate\Support\Facades\DB;

class Search
{
    /**
     * @param string $address
     * @param string|null $region
     * @return array
     */
    public static function byAddress(string $address, string $region = null) : array
    {
        $best_candidate = null;
        $addresses = DB::select('SELECT * FROM fias_address_search(?, ?)', [$address, $region]);

        return compact('addresses');
    }
}
