<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\OperationStatus;

class ImportOperationStatus extends OperationStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_OPERSTAT_';

    protected $xml_object_tag_name = 'OperationStatus';

    protected $import_fields = [
        'operstatid' => 'OPERSTATID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'operstatid',
    ];

    protected $fias_key_field = 'operstatid';

}