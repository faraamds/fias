<?php


namespace faraamds\fias\Models\Import;


use faraamds\fias\Models\Room;
use Illuminate\Database\Eloquent\Model;

class ImportRoom extends FiasImport
{
    protected $xml_file_prefix = 'AS_ROOM_';

    protected $xml_object_tag_name = 'Room';

    protected $import_fields = [
        'roomguid' => 'ROOMGUID',
        'flatnumber' => 'FLATNUMBER',
        'flattype' => 'FLATTYPE',
        'roomnumber' => 'ROOMNUMBER',
        'roomtype' => 'ROOMTYPE',
        'regioncode' => 'REGIONCODE',
        'postalcode' => 'POSTALCODE',
        'updatedate' => 'UPDATEDATE',
        'houseguid' => 'HOUSEGUID',
        'roomid' => 'ROOMID',
        'previd' => 'PREVID',
        'nextid' => 'NEXTID',
        'startdate' => 'STARTDATE',
        'enddate' => 'ENDDATE',
        'livestatus' => 'LIVESTATUS',
        'normdoc' => 'NORMDOC',
        'operstatus' => 'OPERSTATUS',
        'cadnum' => 'CADNUM',
        'roomcadnum' => 'ROOMCADNUM',
    ];

    protected $index_fields = [
        'houseguid', 'roomguid', 'roomid', 'previd', 'nextid',
    ];

    protected $fias_key_field = 'roomid';

    /**
     * @return Model
     */
    protected function getModelObject(): Model
    {
        return new Room;
    }
}