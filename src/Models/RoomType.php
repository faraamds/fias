<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class RoomType extends Model
{
    protected $table = 'fias_room_type';

    protected $fillable = ['rmtypeid', 'name', 'shortname', ];

    protected $visible = ['id', 'rmtypeid', 'name', 'shortname', ];
   
    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
