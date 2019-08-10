<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quyennhomnguoidung extends Model {
    public    $timestamps   = false;

    protected $table        = 'quyennhomnguoidung';
    protected $fillable     = ['thoigianthem'];
    protected $guarded      = ['quyen', 'manhom'];

    protected $primaryKey   = ['quyen', 'manhom'];
    public    $incrementing = false;


    protected $dates        = ['thoigianthem'];
    protected $dateFormat   = 'Y-m-d H:i:s';
}