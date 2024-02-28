<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'no_transaksi',
        'tgl_transaksi',
        'diskon',
        'total_bayar',
    ];

    protected $dates = ['tgl_transaksi'];
}
