<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donvibanhanh extends Model {
    public    $timestamps   = false;

    protected $table        = 'donvibanhanh';
    protected $fillable     = ['tendonvi', 'benngoai', 'sodienthoai', 'email', 'diachi','thoigianthem'];
    protected $guarded      = ['madonvi'];

    protected $primaryKey   = 'madonvi';
    public    $incrementing = false;


    protected $dates        = ['thoigianthem'];
    protected $dateFormat   = 'Y-m-d H:i:s';
}