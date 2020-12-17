<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class AddressObjectType extends Model
{
    protected $table = 'fias_address_object_type';

    protected $fillable = ['level', 'scname', 'socrname', 'kod_t_st', ];

    protected $visible = ['id', 'level', 'scname', 'socrname', 'kod_t_st', ];


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
