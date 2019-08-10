<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donvi extends Model {
    public    $timestamps   = false;

    protected $table        = 'donvi';
    protected $fillable     = ['tendonvi', 'email', 'thoigianthem'];
    protected $guarded      = ['madonvi'];

    protected $primaryKey   = 'madonvi';
    public    $incrementing = false;

    protected $dates        = ['thoigianthem'];
    protected $dateFormat   = 'Y-m-d H:i:s';
}