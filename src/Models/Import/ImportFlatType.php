<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\FlatType;
use Illuminate\Database\Eloquent\Model;

class ImportFlatType extends FiasImport
{
    protected $xml_file_prefix = 'AS_FLATTYPE_';

    protected $xml_object_tag_name = 'FlatType';

    protected $import_fields = [
        'fltypeid' => 'FLTYPEID',
        'name' => 'NAME',
        'shortname' => 'SHORTNAME',
    ];

    protected $index_fields = [
        'fltypeid',
    ];

    protected $fias_key_field = 'fltypeid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new FlatType;
    }
}