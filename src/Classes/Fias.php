<?php


namespace faraamds\fias\Classes;


use faraamds\fias\Classes\Import\ImportFromXML;
use faraamds\fias\Classes\Import\UpdateFromXML;
use faraamds\fias\Classes\Search\Search;
use faraamds\fias\Classes\Search\SearchAddressResult;
use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Collection;
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
    public function searchByAddress(string $address, string $region = null) : array
    {
        return Search::byAddress($address, $region);
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
            ->orderByRaw('housenum nulls first')
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
            ->orderByRaw('flatnumber nulls first')
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
     * @return array
     */
    public function getAoChainByGuid(string $guid) : array
    {
        return DB::select('SELECT * FROM fias_address_actual_chain(?)', [$guid]);
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
}
