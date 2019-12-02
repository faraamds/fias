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

class UpdateFromXML extends AbstractImport
{
    public static function run(string $path = null)
    {
        ImportDelNormDocument::update($path);
        ImportNormDocument::update($path);

        ImportActualStatus::update($path);
        ImportAddressObjectType::update($path);
        ImportCenterStatus::update($path);
        ImportCurrentStatus::update($path);
        ImportEstateStatus::update($path);
        ImportFlatType::update($path);
        ImportHouseStateStatus::update($path);
        ImportIntervalStatus::update($path);
        ImportNormDocumentType::update($path);
        ImportOperationStatus::update($path);
        ImportRoomType::update($path);
        ImportStructureStatus::update($path);

        ImportDelAddressObject::update($path);
        ImportDelHouse::update($path);
        ImportDelHouseInterval::update($path);
        ImportDelLandmark::update($path);

        ImportAddressObject::update($path);
        ImportHouse::update($path);
        ImportHouseInterval::update($path);
        ImportLandmark::update($path);
        ImportRoom::update($path);
        ImportStead::update($path);

        static::postImportActions();
    }
}
