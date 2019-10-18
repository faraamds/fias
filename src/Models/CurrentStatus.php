<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class CurrentStatus extends Model
{
    protected $table = 'fias_current_status';

    protected $fillable = ['curentstid', 'name', ];

    protected $visible = ['id', 'curentstid', 'name',];

}