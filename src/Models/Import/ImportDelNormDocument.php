<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\DelNormDocument;
use Illuminate\Database\Eloquent\Model;

class ImportDelNormDocument extends FiasImport
{
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

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new DelNormDocument;
    }
}