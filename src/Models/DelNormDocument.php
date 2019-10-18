<?php


namespace faraamds\fias\Models;


use Illuminate\Database\Eloquent\Model;

class DelNormDocument extends Model
{
    protected $table = 'fias_del_norm_document';

    protected $fillable = ['normdocid', 'docname', 'docdate', 'docnum', 'doctype', 'docimgid',];

    protected $visible = ['id', 'normdocid', 'docname', 'docdate', 'docnum', 'doctype', 'docimgid',];


}