<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\EstateStatus;

class ImportEstateStatus extends EstateStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_ESTSTAT_';

    protected $xml_object_tag_name = 'EstateStatus';

    protected $import_fields = [
        'eststatid' => 'ESTSTATID',
        'name' => 'NAME',
        'shortname' => 'SHORTNAME',
    ];

    protected $index_fields = [
        'eststatid',
    ];

    protected $fias_key_field = 'eststatid';

}