<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'fias_room_type';

    protected $fillable = ['rmtypeid', 'name', 'shortname', ];

    protected $visible = ['id', 'rmtypeid', 'name', 'shortname', ];

}