<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class StructureStatus extends Model
{
    protected $table = 'fias_structure_status';

    protected $fillable = ['strstatid', 'name', 'shortname'];

    protected $visible = ['id', 'strstatid', 'name', 'shortname'];

}