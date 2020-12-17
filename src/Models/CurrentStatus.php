<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class CurrentStatus extends Model
{
    protected $table = 'fias_current_status';

    protected $fillable = ['curentstid', 'name', ];

    protected $visible = ['id', 'curentstid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
