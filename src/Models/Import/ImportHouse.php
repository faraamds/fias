<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\House;
use Illuminate\Database\Eloquent\Model;

class ImportHouse extends FiasImport
{
    protected $xml_file_prefix = 'AS_HOUSE_';

    protected $xml_object_tag_name = 'House';

    protected $import_fields = [
        'postalcode' => 'POSTALCODE',
        'regioncode' => 'REGIONCODE',
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
        'houseid', 'houseguid', 'aoguid', 'is_last',
    ];

    protected $fias_key_field = 'houseid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new House;
    }
}