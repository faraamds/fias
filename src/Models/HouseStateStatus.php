<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class HouseStateStatus extends Model
{
    protected $table = 'fias_house_state_status';

    protected $fillable = ['housestid', 'name', ];

    protected $visible = ['id', 'housestid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
