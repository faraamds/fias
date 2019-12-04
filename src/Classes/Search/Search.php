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

    /**
     * @param string $aoguid
     * @param string $house
     * @param string|null $building
     * @param string|null $structure
     * @param string|null $room
     * @return SearchHouseRoomResult
     */
    public static function houseAndRoom(string $aoguid, string $house, string $building = null, string $structure = null, string $room = null) : SearchHouseRoomResult
    {
        return (new SearchHouseRoomResult())->find($aoguid, $house, $building, $structure, $room);
    }

}
