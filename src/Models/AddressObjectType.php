<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class AddressObjectType extends Model
{
    protected $table = 'fias_address_object_type';

    protected $fillable = ['level', 'scname', 'socrname', 'kod_t_st', ];

    protected $visible = ['id', 'level', 'scname', 'socrname', 'kod_t_st', ];


}