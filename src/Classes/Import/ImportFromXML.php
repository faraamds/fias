<?php


namespace faraamds\fias\Classes\Import;


use faraamds\fias\Models\AddressObject;
use faraamds\fias\Models\DelAddressObject;
use faraamds\fias\Models\DelHouse;
use faraamds\fias\Models\DelHouseInterval;
use faraamds\fias\Models\DelLandmark;
use faraamds\fias\Models\House;
use faraamds\fias\Models\HouseInterval;
use faraamds\fias\Models\Import\ImportActualStatus;
use faraamds\fias\Models\Import\ImportAddressObject;
use faraamds\fias\Models\Import\ImportAddressObjectType;
use faraamds\fias\Models\Import\ImportCenterStatus;
use faraamds\fias\Models\Import\ImportCurrentStatus;
use faraamds\fias\Models\Import\ImportDelAddressObject;
use faraamds\fias\Models\Import\ImportDelHouse;
use faraamds\fias\Models\Import\ImportDelHouseInterval;
use faraamds\fias\Models\Import\ImportDelLandmark;
use faraamds\fias\Models\Import\ImportDelNormDocument;
use faraamds\fias\Models\Import\ImportEstateStatus;
use faraamds\fias\Models\Import\ImportFlatType;
use faraamds\fias\Models\Import\ImportHouse;
use faraamds\fias\Models\Import\ImportHouseInterval;
use faraamds\fias\Models\Import\ImportHouseStateStatus;
use faraamds\fias\Models\Import\ImportIntervalStatus;
use faraamds\fias\Models\Import\ImportLandmark;
use faraamds\fias\Models\Import\ImportNormDocument;
use faraamds\fias\Models\Import\ImportNormDocumentType;
use faraamds\fias\Models\Import\ImportOperationStatus;
use faraamds\fias\Models\Import\ImportRoom;
use faraamds\fias\Models\Import\ImportRoomType;
use faraamds\fias\Models\Import\ImportStead;
use faraamds\fias\Models\Import\ImportStructureStatus;
use faraamds\fias\Models\Landmark;
use Illuminate\Support\Facades\DB;

class ImportFromXML
{
    public static function run(string $path = null)
    {
        ImportDelNormDocument::import($path);
        ImportNormDocument::import($path);

        ImportActualStatus::import($path);
        ImportAddressObjectType::import($path);
        ImportCenterStatus::import($path);
        ImportCurrentStatus::import($path);
        ImportEstateStatus::import($path);
        ImportFlatType::import($path);
        ImportHouseStateStatus::import($path);
        ImportIntervalStatus::import($path);
        ImportNormDocumentType::import($path);
        ImportOperationStatus::import($path);
        ImportRoomType::import($path);
        ImportStructureStatus::import($path);

        ImportDelAddressObject::import($path);
        ImportDelHouse::import($path);
        ImportDelHouseInterval::import($path);
        ImportDelLandmark::import($path);

        ImportAddressObject::import($path);
        ImportHouse::import($path);
        ImportHouseInterval::import($path);
        ImportLandmark::import($path);
        ImportRoom::import($path);
        ImportStead::import($path);

        AddressObject::whereRaw('aoid IN (' . DelAddressObject::select('aoid')->toSql() . ')')->delete();
        House::whereRaw('houseid IN (' . DelHouse::select('houseid')->toSql() . ')')->delete();
        HouseInterval::whereRaw('houseintid IN (' . DelHouseInterval::select('houseintid')->toSql() . ')')->delete();
        Landmark::whereRaw('landid IN (' . DelLandmark::select('landid')->toSql() . ')')->delete();

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

        DB::select('select * from fias_address_fill_help_search_table()');

    }
}