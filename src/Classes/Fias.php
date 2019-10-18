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
}