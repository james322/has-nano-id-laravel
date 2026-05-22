<?php

namespace james322\HasNanoId\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use james322\HasNanoId\HasNanoId;

class NanoIdModel extends Model
{
    use HasNanoId;
}
