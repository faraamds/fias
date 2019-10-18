<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\AddressObjectType;

class ImportAddressObjectType extends AddressObjectType
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_SOCRBASE_';

    protected $xml_object_tag_name = 'AddressObjectType';

    protected $import_fields = [
        'level' => 'LEVEL',
        'scname' => 'SCNAME',
        'socrname' => 'SOCRNAME',
        'kod_t_st' => 'KOD_T_ST',
    ];

    protected $index_fields = [
        'kod_t_st',
    ];

    protected $fias_key_field = 'kod_t_st';

}