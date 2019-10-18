<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\Stead;

class ImportStead extends Stead
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_STEAD_';

    protected $xml_object_tag_name = 'Stead';

    protected $import_fields = [
        'steadguid' => 'STEADGUID',
        'number' => 'NUMBER',
        'regioncode' => 'REGIONCODE',
        'postalcode' => 'POSTALCODE',
        'ifnsfl' => 'IFNSFL',
        'terrifnsfl' => 'TERRIFNSFL',
        'ifnsul' => 'IFNSUL',
        'terrifnsul' => 'TERRIFNSUL',
        'okato' => 'OKATO',
        'oktmo' => 'OKTMO',
        'updatedate' => 'UPDATEDATE',
        'parentguid' => 'PARENTGUID',
        'steadid' => 'STEADID',
        'previd' => 'PREVID',
        'nextid' => 'NEXTID',
        'operstatus' => 'OPERSTATUS',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'normdoc' => 'NORMDOC',
        'livestatus' => 'LIVESTATUS',
        'cadnum' => 'CADNUM',
        'divtype' => 'DIVTYPE',
    ];

    protected $index_fields = [
        'steadguid', 'parentguid', 'steadid', 'previd', 'nextid',
    ];

    protected $fias_key_field = 'steadid';

}