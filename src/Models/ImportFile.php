<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class ImportFile extends Model
{
    public $timestamps = false;

    protected $table = 'fias_import';

    protected $fillable = [ 'timestamp', 'filename', ];

    protected $visible = [ 'id', 'timestamp', 'filename', ];

}