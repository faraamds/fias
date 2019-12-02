<?php


namespace faraamds\fias\Classes\Import;


use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\DelAddressObject;
use faraamds\fias\Models\DelHouse;
use faraamds\fias\Models\DelHouseInterval;
use faraamds\fias\Models\DelLandmark;
use faraamds\fias\Models\House;
use faraamds\fias\Models\HouseInterval;
use faraamds\fias\Models\Landmark;
use Illuminate\Support\Facades\DB;

abstract class AbstractImport
{
    protected static function postImportActions() : void
    {
        echo("Removing deleted address_objects ...");
        AddressObject::whereRaw('aoid IN (' . DelAddressObject::select('aoid')->toSql() . ')')->delete();
        echo("done\nRemoving deleted houses ...");
        House::whereRaw('houseid IN (' . DelHouse::select('houseid')->toSql() . ')')->delete();
        echo("done\nRemoving deleted house intervals ...");
        HouseInterval::whereRaw('houseintid IN (' . DelHouseInterval::select('houseintid')->toSql() . ')')->delete();
        echo("done\nRemoving deleted landmarks ...");
        Landmark::whereRaw('landid IN (' . DelLandmark::select('landid')->toSql() . ')')->delete();

        echo("done\nRemoving bad references in address_object table ...");
        AddressObject::whereNotNull('nextid')
            ->whereRaw('NOT EXISTS (SELECT 1 FROM fias_address_object fa WHERE fa.aoid=fias_address_object.nextid)')            ->whereRaw('nextid NOT IN (' . AddressObject::select('aoid')->toSql() . ')')
            ->update([
                'nextid' => null,
            ]);

        AddressObject::whereNotNull('previd')
            ->whereRaw('NOT EXISTS (SELECT 1 FROM fias_address_object fa WHERE fa.aoid=fias_address_object.previd)')
            ->update([
                'previd' => null,
            ]);

        echo("done\nCreating address search table ...");
        DB::select('select * from fias_address_fill_help_search_table()');
        echo("done\n");
    }
}
