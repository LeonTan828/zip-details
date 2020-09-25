<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipInput extends Model
{
    protected $table = "zipinputs";

    protected $primaryKey = "zip_code";
    public $incrementing = false;
    protected $keyType = "string";
}
