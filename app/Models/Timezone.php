<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = "timezones";

    protected $primaryKey = "timezone_identifier";
    public $incrementing = false;
    protected $keyType = "string";
}
