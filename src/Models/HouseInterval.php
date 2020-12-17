<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

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

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
