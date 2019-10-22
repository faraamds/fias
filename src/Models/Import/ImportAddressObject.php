<?php


namespace faraamds\fias\Models\Import;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use faraamds\fias\Models\AddressObject;

class ImportAddressObject extends FiasImport
{
    protected $xml_file_prefix = 'AS_ADDROBJ_';

    protected $xml_object_tag_name = 'Object';

    protected $import_fields = [
        'aoguid' => 'AOGUID',
        'formalname' => 'FORMALNAME',
        'regioncode' => 'REGIONCODE',
        'autocode' => 'AUTOCODE',
        'areacode' => 'AREACODE',
        'citycode' => 'CITYCODE',
        'ctarcode' => 'CTARCODE',
        'placecode' => 'PLACECODE',
        'plancode' => 'PLANCODE',
        'streetcode' => 'STREETCODE',
        'extrcode' => 'EXTRCODE',
        'sextcode' => 'SEXTCODE',
        'offname' => 'OFFNAME',
        'postalcode' => 'POSTALCODE',
        'ifnsfl' => 'IFNSFL',
        'terrifnsfl' => 'TERRIFNSFL',
        'ifnsul' => 'IFNSUL',
        'terrifnsul' => 'TERRIFNSUL',
        'okato' => 'OKATO',
        'oktmo' => 'OKTMO',
        'updatedate' => 'UPDATEDATE',
        'shortname' => 'SHORTNAME',
        'aolevel' => 'AOLEVEL',
        'parentguid' => 'PARENTGUID',
        'aoid' => 'AOID',
        'previd' => 'PREVID',
        'nextid' => 'NEXTID',
        'code' => 'CODE',
        'plaincode' => 'PLAINCODE',
        'actstatus' => 'ACTSTATUS',
        'centstatus' => 'CENTSTATUS',
        'operstatus' => 'OPERSTATUS',
        'currstatus' => 'CURRSTATUS',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'normdoc' => 'NORMDOC',
        'livestatus' => 'LIVESTATUS',
        'divtype' => 'DIVTYPE',
    ];

    protected $index_fields = [
        'parent_id', 'real_depth', 'position', 'aoguid', 'aoid', 'parentguid', 'previd', 'nextid',
    ];

    protected $fias_key_field = 'aoid';

    protected function additionalImportActions(): void
    {
        if (strtoupper(app('db')->getDefaultConnection()) === 'PGSQL') {

            DB::unprepared('CREATE INDEX idx_gin_fias_address_object ON fias_address_object USING gin (to_tsvector(\'russian\', formalname))');
        }
    }

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new AddressObject;
    }
}