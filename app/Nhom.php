<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nhom extends Model {
    public    $timestamps   = false;

    protected $table        = 'nhom';
    protected $fillable     = ['tennhom', 'thoigianthem'];
    protected $guarded      = ['manhom'];

    protected $primaryKey   = 'manhom';
    public    $incrementing = false;

    protected $dates        = ['thoigianthem'];
    protected $dateFormat   = 'Y-m-d H:i:s';
}