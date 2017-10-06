<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    protected  $primaryKey='id';
    protected $table = 'employees';
}
