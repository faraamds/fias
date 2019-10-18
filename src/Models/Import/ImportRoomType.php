<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\RoomType;

class ImportRoomType extends RoomType
{
    use CommonXMLImport, CommonXMLUpdate;

    protected $xml_file_prefix = 'AS_ROOMTYPE_';

    protected $xml_object_tag_name = 'RoomType';

    protected $import_fields = [
        'rmtypeid' => 'RMTYPEID',
        'name' => 'NAME',
        'shortname' => 'SHORTNAME',
    ];

    protected $index_fields = [
        'rmtypeid',
    ];

    protected $fias_key_field = 'rmtypeid';

}