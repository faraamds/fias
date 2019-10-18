<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\DelNormDocument;

class ImportDelNormDocument extends DelNormDocument
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_DEL_NORMDOC_';

    protected $xml_object_tag_name = 'NormativeDocument';

    protected $import_fields = [
        'normdocid' => 'NORMDOCID',
        'docname' => 'DOCNAME',
        'docdate' => 'DOCDATE',
        'docnum' => 'DOCNUM',
        'doctype' => 'DOCTYPE',
        'docimgid' => 'DOCIMGID',
    ];

    protected $index_fields = [
        'normdocid',
    ];

    protected $fias_key_field = 'normdocid';

}