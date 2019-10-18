<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class FlatType extends Model
{
    protected $table = 'fias_flat_type';

    protected $fillable = ['fltypeid', 'name', 'shortname', ];

    protected $visible = ['id', 'fltypeid', 'name', 'shortname', ];

}