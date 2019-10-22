<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\StructureStatus;
use Illuminate\Database\Eloquent\Model;

class ImportStructureStatus extends FiasImport
{
    protected $xml_file_prefix = 'AS_STRSTAT_';

    protected $xml_object_tag_name = 'StructureStatus';

    protected $import_fields = [
        'strstatid' => 'STRSTATID',
        'name' => 'NAME',
        'shortname' => 'SHORTNAME',
    ];

    protected $index_fields = [
        'strstatid',
    ];

    protected $fias_key_field = 'strstatid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new StructureStatus;
    }
}