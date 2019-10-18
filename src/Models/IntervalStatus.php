<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class IntervalStatus extends Model
{
    protected $table = 'fias_interval_status';

    protected $fillable = ['intvstatid', 'name', ];

    protected $visible = ['id', 'intvstatid', 'name',];

}