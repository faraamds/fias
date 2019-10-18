<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class Stead extends Model
{
    protected $table = 'fias_stead';

    protected $fillable = ['steadguid', 'number', 'regioncode', 'postalcode', 'ifnsfl', 'terrifnsfl',
        'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'parentguid', 'steadid', 'previd',
        'nextid', 'operstatus', 'startdate', 'enddate', 'normdoc', 'livestatus', 'cadnum', 'divtype',];

    protected $visible = ['id', 'steadguid', 'number', 'regioncode', 'postalcode', 'ifnsfl', 'terrifnsfl',
        'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'parentguid', 'steadid', 'previd',
        'nextid', 'operstatus', 'startdate', 'enddate', 'normdoc', 'livestatus', 'cadnum', 'divtype',];


}