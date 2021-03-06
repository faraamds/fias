<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\NormDocument;
use Illuminate\Database\Eloquent\Model;

class ImportNormDocument extends FiasImport
{
    protected $xml_file_prefix = 'AS_NORMDOC_';

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
        return new NormDocument;
    }
}