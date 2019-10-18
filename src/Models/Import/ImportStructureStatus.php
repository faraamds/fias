<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\StructureStatus;

class ImportStructureStatus extends StructureStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_STRSTAT_';

    protected $xml_object_tag_name = 'StructureStatus';

    protected $import_fields = [
        'strstatid' => 'STRSTATID',
        'name' => 'NAME',
        'shortname' => 'SHORTNAME',
    ];

    protected $index_fields = [
        'strstatid',
    ];

    protected $fias_key_field = 'strstatid';

}