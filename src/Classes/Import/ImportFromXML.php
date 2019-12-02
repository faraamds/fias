<?php


namespace faraamds\fias\Classes\Import;


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

class ImportFromXML extends AbstractImport
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

        static::postImportActions();
    }
}
