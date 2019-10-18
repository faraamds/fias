<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class HouseStateStatus extends Model
{
    protected $table = 'fias_house_state_status';

    protected $fillable = ['housestid', 'name', ];

    protected $visible = ['id', 'housestid', 'name',];

}