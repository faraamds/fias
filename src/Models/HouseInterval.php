<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class HouseInterval extends Model
{
    protected $table = 'fias_house_interval';

    protected $fillable = [
        'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'intstart',
        'intend', 'houseintid', 'intguid', 'aoguid', 'startdate', 'enddate', 'intstatus', 'normdoc', 'counter',
    ];

    protected $visible = [
        'id', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'intstart',
        'intend', 'houseintid', 'intguid', 'aoguid', 'startdate', 'enddate', 'intstatus', 'normdoc', 'counter',
        ];

}