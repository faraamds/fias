<?php


namespace faraamds\fias\Facades;


use faraamds\fias\Classes\Search\SearchAddressResult;
use faraamds\fias\Classes\Search\SearchHouseRoomResult;
use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class Fias
 * @package faraamds\fias\Facades
 *
 * @method static void                   import(string $path = null)
 * @method static void                   update(string $path = null)
 * @method static array                  searchByAddress(string $address, string $region = null)
 * @method static SearchHouseRoomResult  searchHouseAndRoom(string $aoguid, string $house, string $building = null, string $structure = null, string $room = null)
 * @method static SearchAddressResult    getFullInfo(string $aoguid, string $houseguid = null, string $roomguid = null)
 * @method static Collection             getHousesByAoguid(string $aoguid)
 * @method static Collection             getRoomByHouseguid(string $houseguid)
 * @method static AddressObject          getAoByGuid(string $guid)
 * @method static House                  getHouseByGuid(string $guid)
 * @method static Room                   getRoomByGuid(string $guid)
 * @method static array                  getAoChainByGuid(string $guid, string $keywords = null)
 */
class Fias extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'fias.fias'; }

}
