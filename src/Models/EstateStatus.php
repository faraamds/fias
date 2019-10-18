<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class EstateStatus extends Model
{
    protected $table = 'fias_estate_status';

    protected $fillable = ['eststatid', 'name', 'shortname', ];

    protected $visible = ['id', 'eststatid', 'name', 'shortname', ];

}