<?php

namespace App;

use App\Pembelian;
use App\Penjualan;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    public function getCustomer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function getTransaction()
    {
        if($this->type_transaction == 1){
            return $this->belongsTo(Pembelian::class, 'id_transaction', 'id');
        } else {
            return $this->belongsTo(Penjualan::class, 'id_transaction', 'id');
        }
    }

    public function getJatuhTempo()
    {
        if ($this->tgl_pelunasan) {
            $remaining_days = Carbon::create(Carbon::now()->startOfDay())->startOfDay()->diffInDays(carbon::parse($this->tgl_pelunasan)->startOfDay(), false);
        } else {
            $remaining_days = 0;
        }
        return $remaining_days;
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }

    public function getJenisTelur()
    {
        return $this->belongsTo(JenisTelur::class, 'id_jenis_telur', 'id');
    }
}
