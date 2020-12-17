<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class FlatType extends Model
{
    protected $table = 'fias_flat_type';

    protected $fillable = ['fltypeid', 'name', 'shortname', ];

    protected $visible = ['id', 'fltypeid', 'name', 'shortname', ];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
