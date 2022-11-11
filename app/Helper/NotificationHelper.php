<?php

namespace App\Helper;

use App\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationHelper{
    public static function createNotification($type, $id_toko_gudang, $id_transaction, $title, $read)
    {
        $notification = new Notification();
        $notification->type = $type;
        $notification->id_user = Auth::user()->id;
        $notification->id_toko_gudang = $id_toko_gudang;
        $notification->id_transaction = $id_transaction;
        $notification->title = $title;
        $notification->read = $read;
        $notification->save();
    }
    public static function updateNotification($id, $id_transaction)
    {
        $notification = Notification::where('type', 1)->where('id_transaction', $id)->first();
        $notification->id_transaction = $id_transaction;
        $notification->save();
    }
}
