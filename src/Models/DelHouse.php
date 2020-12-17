<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class DelHouse extends Model
{
    protected $table = 'fias_del_house';

    protected $fillable = [
        'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'housenum',
        'eststatus', 'buildnum', 'strucnum', 'strstatus', 'houseid', 'houseguid', 'aoguid', 'startdate', 'enddate',
        'statstatus', 'normdoc', 'counter', 'cadnum', 'divtype',
    ];

    protected $visible = [
        'id', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'housenum',
        'eststatus', 'buildnum', 'strucnum', 'strstatus', 'houseid', 'houseguid', 'aoguid', 'startdate', 'enddate',
        'statstatus', 'normdoc', 'counter', 'cadnum', 'divtype',
        ];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
