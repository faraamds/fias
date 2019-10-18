<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\CurrentStatus;

class ImportCurrentStatus extends CurrentStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_CURENTST_';

    protected $xml_object_tag_name = 'CurrentStatus';

    protected $import_fields = [
        'curentstid' => 'CURENTSTID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'curentstid'
    ];

    protected $fias_key_field = 'curentstid';

}