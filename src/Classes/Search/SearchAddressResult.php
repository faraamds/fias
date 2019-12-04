<?php


namespace faraamds\fias\Classes\Search;


use faraamds\fias\Facades\Fias;
use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;

class SearchAddressResult
{
    /** @var AddressObject */
    protected ?AddressObject $addressObject;

    /** @var House */
    protected ?House $house;

    /** @var Room */
    protected ?Room $room;

    /**
     * SearchAddressResult constructor.
     */
    public function __construct()
    {
        $this->addressObject = null;
        $this->house = null;
        $this->room = null;
    }

    /**
     * @param string $aoguid
     * @param string|null $houseguid
     * @param string|null $roomguid
     * @return SearchAddressResult
     */
    public function fill(string $aoguid, string $houseguid = null, string $roomguid = null) : self
    {
        $this->findAddressObject($aoguid);
        if ($houseguid) {
            $this->findHouse($houseguid);
        }
        if ($roomguid) {
            $this->findRoom($roomguid);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toJson() : string
    {
        $address_object = $this->addressObject;
        $house = $this->house;
        $room = $this->room;

        return json_encode(compact('address_object', 'house', 'room'));
    }

    /**
     * @param string $aoguid
     */
    protected function findAddressObject(string $aoguid): void
    {
        $this->addressObject = Fias::getAoByGuid($aoguid);
    }

    /**
     * @param string $houseguid
     */
    protected function findHouse(string $houseguid) : void
    {
        $this->house = Fias::getHouseByGuid($houseguid);
    }

    /**
     * @param string $roomguid
     */
    protected function findRoom(string $roomguid) : void
    {
        $this->room = Fias::getRoomByGuid($roomguid);
    }
}
