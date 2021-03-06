<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class DelNormDocument extends Model
{
    protected $table = 'fias_del_norm_document';

    protected $fillable = ['normdocid', 'docname', 'docdate', 'docnum', 'doctype', 'docimgid',];

    protected $visible = ['id', 'normdocid', 'docname', 'docdate', 'docnum', 'doctype', 'docimgid',];


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
