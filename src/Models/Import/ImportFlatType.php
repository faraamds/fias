<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\FlatType;

class ImportFlatType extends FlatType
{
    use CommonXMLImport, CommonXMLUpdate;

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

}