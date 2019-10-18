<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\NormDocumentType;

class ImportNormDocumentType extends NormDocumentType
{
    use CommonXMLImport, CommonXMLUpdate;

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

}