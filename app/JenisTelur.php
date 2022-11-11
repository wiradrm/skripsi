<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TelurMasuk;

class JenisTelur extends Model
{
    public function getStockActive()
    {
        return $this->belongsTo(TelurMasuk::class, 'id_stock_active', 'id');
    }
}
