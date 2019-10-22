<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\NormDocumentType;
use Illuminate\Database\Eloquent\Model;

class ImportNormDocumentType extends FiasImport
{
    protected $xml_file_prefix = 'AS_NDOCTYPE_';

    protected $xml_object_tag_name = 'NormativeDocumentType';

    protected $import_fields = [
        'ndtypeid' => 'NDTYPEID',
        'name' => 'NAME',
    ];

    protected $index_fields = [
        'ndtypeid',
    ];

    protected $fias_key_field = 'ndtypeid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new NormDocumentType;
    }
}