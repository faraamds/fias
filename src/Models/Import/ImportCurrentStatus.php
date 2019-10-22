<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\CurrentStatus;
use Illuminate\Database\Eloquent\Model;

class ImportCurrentStatus extends FiasImport
{
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

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new CurrentStatus;
    }
}