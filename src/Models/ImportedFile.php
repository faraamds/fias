<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class ImportedFile extends Model
{
    public $timestamps = false;

    protected $table = 'fias_imported_file';

    protected $fillable = [ 'timestamp', 'filename', ];

    protected $visible = [ 'id', 'timestamp', 'filename', ];

}