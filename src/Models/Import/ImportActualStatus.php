<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\ActualStatus;

class ImportActualStatus extends ActualStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_ACTSTAT_';

    protected $xml_object_tag_name = 'ActualStatus';

    protected $import_fields = [
        'actstatid' => 'ACTSTATID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'actstatid',
    ];

    protected $fias_key_field = 'actstatid';
}