<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class NormDocumentType extends Model
{
    protected $table = 'fias_norm_doc_type';

    protected $fillable = ['ndtypeid', 'name', ];

    protected $visible = ['id', 'ndtypeid', 'name',];

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
