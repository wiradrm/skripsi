<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }

    public function uploadImage($image, $name)
    {
        $des    = 'storage/image/nota/';
        $image->move($des, $name);
    }

    public function getImage()
    {
        $path   = 'storage/image/nota/';
        return url($path . $this->image);
    }
}
