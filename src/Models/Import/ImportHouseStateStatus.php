<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\HouseStateStatus;
use Illuminate\Database\Eloquent\Model;

class ImportHouseStateStatus extends FiasImport
{
    protected $xml_file_prefix = 'AS_HSTSTAT_';

    protected $xml_object_tag_name = 'HouseStateStatus';

    protected $import_fields = [
        'housestid' => 'HOUSESTID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'housestid',
    ];

    protected $fias_key_field = 'housestid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new HouseStateStatus;
    }
}