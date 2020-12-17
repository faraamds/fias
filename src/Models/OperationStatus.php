<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class OperationStatus extends Model
{
    protected $table = 'fias_operation_status';

    protected $fillable = ['operstatid', 'name', ];

    protected $visible = ['id', 'operstatid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
