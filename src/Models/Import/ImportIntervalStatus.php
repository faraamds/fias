<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\IntervalStatus;

class ImportIntervalStatus extends IntervalStatus
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_INTVSTAT_';

    protected $xml_object_tag_name = 'IntervalStatus';

    protected $import_fields = [
        'intvstatid' => 'INTVSTATID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'intvstatid',
    ];

    protected $fias_key_field = 'intvstatid';

}