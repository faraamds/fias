<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class NormDocumentType extends Model
{
    protected $table = 'fias_norm_doc_type';

    protected $fillable = ['ndtypeid', 'name', ];

    protected $visible = ['id', 'ndtypeid', 'name',];

}