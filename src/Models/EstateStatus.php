<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class EstateStatus extends Model
{
    protected $table = 'fias_estate_status';

    protected $fillable = ['eststatid', 'name', 'shortname', ];

    protected $visible = ['id', 'eststatid', 'name', 'shortname', ];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
