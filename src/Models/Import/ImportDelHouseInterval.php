<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\DelHouseInterval;

class ImportDelHouseInterval extends DelHouseInterval
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_DEL_HOUSEINT_';

    protected $xml_object_tag_name = 'HouseInterval';

    protected $import_fields = [
        'postalcode' => 'POSTALCODE',
        'ifnsfl' => 'IFNSFL',
        'terrifnsfl' => 'TERRIFNSFL',
        'ifnsul' => 'IFNSUL',
        'terrifnsul' => 'TERRIFNSUL',
        'okato' => 'OKATO',
        'oktmo' => 'OKTMO',
        'updatedate' => 'UPDATEDATE',
        'intstart' => 'INTSTART',
        'intend' => 'INTEND',
        'houseintid' => 'HOUSEINTID',
        'intguid' => 'INTGUID',
        'aoguid' => 'AOGUID',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'intstatus' => 'INTSTATUS',
        'normdoc' => 'NORMDOC',
        'counter' => 'COUNTER',
    ];

    protected $index_fields = [
        'houseintid', 'intguid', 'aoguid',
    ];

    protected $fias_key_field = 'houseintid';

}