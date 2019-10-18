<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\DelHouse;

class ImportDelHouse extends DelHouse
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_DEL_HOUSE_';

    protected $xml_object_tag_name = 'House';

    protected $import_fields = [
        'postalcode' => 'POSTALCODE',
        'ifnsfl' => 'IFNSFL',
        'terrifnsfl' => 'TERRIFNSFL',
        'ifnsul' => 'IFNSUL',
        'terrifnsul' => 'TERRIFNSUL',
        'okato' => 'OKATO',
        'oktmo' => 'OKTMO',
        'updatedate' => 'UPDATEDATE',
        'housenum' => 'HOUSENUM',
        'eststatus' => 'ESTSTATUS',
        'buildnum' => 'BUILDNUM',
        'strucnum' => 'STRUCNUM',
        'strstatus' => 'STRSTATUS',
        'houseid' => 'HOUSEID',
        'houseguid' => 'HOUSEGUID',
        'aoguid' => 'AOGUID',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'statstatus' => 'STATSTATUS',
        'normdoc' => 'NORMDOC',
        'counter' => 'COUNTER',
        'cadnum' => 'CADNUM',
        'divtype' => 'DIVTYPE',
    ];

    protected $index_fields = [
        'houseid', 'houseguid', 'aoguid',
    ];

    protected $fias_key_field = 'houseid';

}