<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\RoomType;
use Illuminate\Database\Eloquent\Model;

class ImportRoomType extends FiasImport
{
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

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new RoomType;
    }
}