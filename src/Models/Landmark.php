<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    protected $table = 'fias_landmark';

    protected $fillable = ['location', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul',
        'okato', 'oktmo', 'updatedate', 'landid', 'landguid', 'aoguid', 'startdate', 'enddate',
        'normdoc', ];

    protected $visible = ['id', 'location', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul',
        'okato', 'oktmo', 'updatedate', 'landid', 'landguid', 'aoguid', 'startdate', 'enddate',
        'normdoc', ];


}