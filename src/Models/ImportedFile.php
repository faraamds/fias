<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ImportedFile extends Model
{
    public $timestamps = false;

    protected $table = 'fias_imported_file';

    protected $fillable = [ 'timestamp', 'filename', ];

    protected $visible = [ 'id', 'timestamp', 'filename', ];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
