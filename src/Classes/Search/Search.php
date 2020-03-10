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
        $query = Query::toQuery($address);

        $addresses = SphinxSearch::search($query);

        return compact('addresses');
    }

    /**
     * @param string $address
     * @param string|null $region
     * @return array
     */
    public static function byAddressWholeWords(string $address, string $region = null) : array
    {
        $addresses = SphinxSearch::search($address);

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
