<?php


namespace faraamds\fias\Classes;


use Carbon\Carbon;
use faraamds\fias\Classes\Import\ImportFromXML;
use faraamds\fias\Classes\Import\UpdateFromXML;
use faraamds\fias\Classes\Search\Search;
use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class Fias
{
    public function import(string $path = null)
    {
        ImportFromXML::run($path);
    }

    public function update(string $path = null)
    {
        UpdateFromXML::run($path);
    }

    /**
     * @param string $address
     * @return array
     */
    public function searchByAddressString(string $address)
    {
        return Search::byAddressString($address);
    }

    /**
     * @param string $address
     * @param string|null $house
     * @param string|null $building
     * @param string|null $apartment
     * @param string|null $region
     * @return array
     */
    public function searchByAddress(string $address, string $house = null, string $building = null, string $apartment = null, string $region = null)
    {
        return Search::byAddress($address, $house, $building, $apartment, $region);
    }

    /**
     * @param string $aoguid
     * @return Collection|House[]
     */
    public function getHousesByAoguid(string $aoguid) : Collection
    {
        return House::where('aoguid', $aoguid)->get();
    }

    /**
     * @param string $houseguid
     * @return Collection|Room[]
     */
    public function getRoomByHouseguid(string $houseguid) : Collection
    {
        return Room::where('houseguid', $houseguid)->get();
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