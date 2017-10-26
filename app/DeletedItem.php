<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DeletedItem extends Model
{
    protected  $primaryKey='id';
    protected $table = 'deleted_items';
}
