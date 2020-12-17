<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class IntervalStatus extends Model
{
    protected $table = 'fias_interval_status';

    protected $fillable = ['intvstatid', 'name', ];

    protected $visible = ['id', 'intvstatid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
