<?php


namespace faraamds\fias\Facades;


use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\House;
use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class Fias
 * @package faraamds\fias\Facades
 *
 * @method static array searchByAddress(string $address, string $house = null, string $building = null, string $apartment = null, string $region = null)
 * @method static Collection|House[] getHousesByAoguid(string $aoguid)
 * @method static Collection|Room[] getRoomByHouseguid(string $houseguid)
 * @method static AddressObject getAoByGuid(string $guid)
 * @method static House getHouseByGuid(string $guid)
 * @method static Room getRoomByGuid(string $guid)
 * @method static void import(string $path)
 * @method static void update(string $path)
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