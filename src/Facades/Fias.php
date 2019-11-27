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
 * @method array searchByAddress(string $address, string $house = null, string $building = null, string $apartment = null, string $region = null)
 * @method Collection|House[] getHousesByAoguid(string $aoguid)
 * @method Collection|Room[] getRoomByHouseguid(string $houseguid)
 * @method AddressObject getAoByGuid(string $guid)
 * @method House getHouseByGuid(string $guid)
 * @method Room getRoomByGuid(string $guid)
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