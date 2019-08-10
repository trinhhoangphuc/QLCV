<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaivanban extends Model {
    public    $timestamps   = false;

    protected $table        = 'loaivanban';
    protected $fillable     = ['tenloai', 'thoigianthem'];
    protected $guarded      = ['maloai'];

    protected $primaryKey   = 'maloai';
    public    $incrementing = false;


    protected $dates        = ['thoigianthem'];
    protected $dateFormat   = 'Y-m-d H:i:s';
}