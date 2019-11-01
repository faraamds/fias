<?php


namespace faraamds\fias\Classes;


use Carbon\Carbon;
use faraamds\fias\Classes\Import\ImportFromXML;
use faraamds\fias\Classes\Search\Search;

class Fias
{
    public function import(string $path = null)
    {
        echo(Carbon::now() . "\n");
        ImportFromXML::run($path);
        echo(Carbon::now() . "\n");
    }

    public function update(string $path = null)
    {

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
}