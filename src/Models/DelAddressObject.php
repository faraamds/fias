<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class DelAddressObject extends Model
{
    protected $table = 'fias_del_address_object';

    protected $fillable = ['real_depth', 'position', 'aoguid', 'formalname', 'regioncode', 'autocode',
        'areacode', 'citycode', 'ctarcode', 'placecode', 'plancode', 'streetcode', 'extrcode', 'sextcode',
        'offname', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'shortname', 'aolevel', 'parentguid', 'aoid', 'previd', 'nextid', 'code', 'plaincode', 'actstatus',
        'centstatus', 'operstatus', 'currstatus', 'startdate', 'enddate', 'normdoc', 'livestatus',];

    protected $visible = ['id', 'real_depth', 'position', 'aoguid', 'formalname', 'regioncode', 'autocode',
        'areacode', 'citycode', 'ctarcode', 'placecode', 'plancode', 'streetcode', 'extrcode', 'sextcode',
        'offname', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate',
        'shortname', 'aolevel', 'parentguid', 'aoid', 'previd', 'nextid', 'code', 'plaincode', 'actstatus',
        'centstatus', 'operstatus', 'currstatus', 'startdate', 'enddate', 'normdoc', 'livestatus',];


}