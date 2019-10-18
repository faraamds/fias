<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\Landmark;

class ImportLandmark extends Landmark
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_LANDMARK_';

    protected $xml_object_tag_name = 'Landmark';

    protected $import_fields = [
        'location' => 'LOCATION',
        'postalcode' => 'POSTALCODE',
        'ifnsfl' => 'IFNSFL',
        'terrifnsfl' => 'TERRIFNSFL',
        'ifnsul' => 'IFNSUL',
        'terrifnsul' => 'TERRIFNSUL',
        'okato' => 'OKATO',
        'oktmo' => 'OKTMO',
        'updatedate' => 'UPDATEDATE',
        'landid' => 'LANDID',
        'landguid' => 'LANDGUID',
        'aoguid' => 'AOGUID',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'normdoc' => 'NORMDOC',
    ];

    protected $index_fields = [
        'landid', 'landguid', 'aoguid',
    ];

    protected $fias_key_field = 'landid';

}