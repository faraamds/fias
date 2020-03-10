<?php


namespace faraamds\fias\Classes;


use faraamds\fias\Classes\Import\ImportFromXML;
use faraamds\fias\Classes\Import\UpdateFromXML;
use faraamds\fias\Classes\Search\Search;
use faraamds\fias\Classes\Search\SearchAddressResult;
use faraamds\fias\Classes\Search\SearchHouseRoomResult;
use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class Fias
 * @package faraamds\fias\Classes
 */
class Fias
{
    /**
     * @param string|null $path
     */
    public function import(string $path = null) : void
    {
        ImportFromXML::run($path);
    }

    /**
     * @param string|null $path
     */
    public function update(string $path = null) : void
    {
        UpdateFromXML::run($path);
    }

    /**
     * @param string $address
     * @param string|null $region
     * @return array
     */
    public function searchByAddress(string $address, string $region = null, int $limit = 10) : array
    {
        return Search::byAddress($address, $region, $limit);
    }

    /**
     * @param string $address
     * @param string|null $region
     * @return array
     */
    public function searchByAddressWholeWords(string $address, string $region = null, int $limit = 10) : array
    {
        return Search::byAddressWholeWords($address, $region, $limit);
    }

    /**
     * @param string $aoguid
     * @param string $house
     * @param string|null $building
     * @param string|null $structure
     * @param string|null $room
     * @return SearchHouseRoomResult
     */
    public function searchHouseAndRoom(string $aoguid, string $house, string $building = null, string $structure = null, string $room = null) : SearchHouseRoomResult
    {
        return Search::houseAndRoom($aoguid, $house, $building, $structure, $room);
    }

    /**
     * @param string $aoguid
     * @param string|null $houseguid
     * @param string|null $roomguid
     * @return SearchAddressResult
     */
    public function getFullInfo(string $aoguid, string $houseguid = null, string $roomguid = null) : SearchAddressResult
    {
        return (new SearchAddressResult())->fill($aoguid, $houseguid, $roomguid);
    }

    /**
     * @param string $aoguid
     * @return Collection|House[]
     */
    public function getHousesByAoguid(string $aoguid) : Collection
    {
        return House::where('aoguid', $aoguid)
            ->select('houseguid', 'housenum', 'buildnum', 'strucnum')
            ->distinct()
            ->orderBy('housenum')
            ->orderByRaw('buildnum nulls first')
            ->orderByRaw('strucnum nulls first')
            ->get();
    }

    /**
     * @param string $houseguid
     * @return Collection|Room[]
     */
    public function getRoomByHouseguid(string $houseguid) : Collection
    {
        return Room::where('houseguid', $houseguid)
            ->select('roomguid', 'flatnumber', 'roomnumber')
            ->distinct()
            ->orderBy('flatnumber')
            ->orderByRaw('roomnumber nulls first')
            ->get();
    }

    /**
     * @param string $guid
     * @return AddressObject
     */
    public function getAoByGuid(string $guid) : AddressObject
    {
        return AddressObject::where('aoguid', $guid)->orderByDesc('enddate')->first();
    }

    /**
     * @param string $guid
     * @param string|null $keywords
     * @return array
     */
    public function getAoChainByGuid(string $guid, string $keywords = null) : array
    {
        return $keywords
            ? DB::select('SELECT * FROM fias_address_satisfy_chain(?,?)', [$guid, $keywords])
            : DB::select('SELECT * FROM fias_address_actual_chain(?)', [$guid]);
    }

    /**
     * @param string $guid
     * @return House
     */
    public function getHouseByGuid(string $guid) : House
    {
        return House::where('houseguid', $guid)->orderByDesc('enddate')->first();
    }

    /**
     * @param string $guid
     * @return Room
     */
    public function getRoomByGuid(string $guid) : Room
    {
        return Room::where('roomguid', $guid)->orderByDesc('enddate')->first();
    }

    /**
     * @param string $houseguid
     * @return string|null
     */
    public function getAddressByHouseguid(string $houseguid) : ?string
    {
        /** @var House $house */
        $house = House::where('houseguid', $houseguid)->orderByDesc('enddate')->first();
        if (!$house) {
            return null;
        }
        $address_row = Arr::first(DB::select('select * from fias_address_formal(?) str', [$house->aoguid]));
        if (!$address_row) {
            return null;
        }
        $address = $address_row->str;
        $address .= ", дом {$house->housenum}";
        if ($house->buildnum) {
            $address .= ", корпус {$house->buildnum}";
        }
        if ($house->strucnum) {
            $address .= ", строение {$house->strucnum}";
        }
        return $address;
    }
}
