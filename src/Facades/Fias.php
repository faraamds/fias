<?php


namespace faraamds\fias\Facades;


use Illuminate\Support\Facades\Facade;

class Fias extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'fias.fias'; }

}