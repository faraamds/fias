<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ActualStatus extends Model
{
    protected $table = 'fias_actual_status';

    protected $fillable = ['actstatid', 'name', ];

    protected $visible = ['id', 'actstatid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
