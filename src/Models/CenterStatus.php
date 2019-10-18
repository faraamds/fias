<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class CenterStatus extends Model
{
    protected $table = 'fias_center_status';

    protected $fillable = ['centerstid', 'name', ];

    protected $visible = ['id', 'centerstid', 'name',];

}