<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class ActualStatus extends Model
{
    protected $table = 'fias_actual_status';

    protected $fillable = ['actstatid', 'name', ];

    protected $visible = ['id', 'actstatid', 'name',];

}