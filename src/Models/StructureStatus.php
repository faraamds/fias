<?php


namespace faraamds\fias\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class StructureStatus extends Model
{
    protected $table = 'fias_structure_status';

    protected $fillable = ['strstatid', 'name', 'shortname'];

    protected $visible = ['id', 'strstatid', 'name', 'shortname'];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
