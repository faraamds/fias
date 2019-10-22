<?php


namespace faraamds\fias\Models\Import;



use faraamds\fias\Models\CenterStatus;
use Illuminate\Database\Eloquent\Model;

class ImportCenterStatus extends FiasImport
{
    protected $xml_file_prefix = 'AS_CENTERST_';

    protected $xml_object_tag_name = 'CenterStatus';

    protected $import_fields = [
        'centerstid' => 'CENTERSTID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'centerstid'
    ];

    protected $fias_key_field = 'centerstid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new CenterStatus;
    }
}