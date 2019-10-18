<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class OperationStatus extends Model
{
    protected $table = 'fias_operation_status';

    protected $fillable = ['operstatid', 'name', ];

    protected $visible = ['id', 'operstatid', 'name',];

}