<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\EstateStatus;
use Illuminate\Database\Eloquent\Model;

class ImportEstateStatus extends FiasImport
{
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

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new EstateStatus;
    }
}