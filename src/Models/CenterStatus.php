<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class CenterStatus extends Model
{
    protected $table = 'fias_center_status';

    protected $fillable = ['centerstid', 'name', ];

    protected $visible = ['id', 'centerstid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
