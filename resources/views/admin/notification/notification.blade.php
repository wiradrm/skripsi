<li class="nav-item dropdown no-arrow mx-1">
    @if(Auth::user()->level != 2)
    @php($notif = App\Notification::where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('id')->take(10)->get())
    @php($count = App\Notification::where('id_toko_gudang', Auth::user()->id_toko_gudang)->where('read', 1)->count())
    @else
    @php($notif = App\Notification::where('type', '!=', 1)->latest('id')->take(10)->get())
    @php($count = App\Notification::where('type', '!=', 1)->where('readByOwner', 1)->count())
    @endif
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        @if($count != 0)<span class="badge badge-danger badge-counter">{{$count}}</span>@endif
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notification Center
        </h6>
        @if($notif->count() == 0)
        <a class="dropdown-item d-flex justify-content-center align-items-center" href="#">
            <div>
                <span>No data</span>
            </div>
        </a>
        @endif
        @foreach($notif as $key => $item)
        @if($item->type == 1)
        <a class="dropdown-item d-flex align-items-center" href="#" @if($item->read == 1) data-toggle="modal" data-target="#notifModal-{{$item->id}}" @endif>
        @elseif($item->type == 2)
        <a class="dropdown-item d-flex align-items-center" href="{{route('notification.penjualan', $item->id)}}">
        @elseif($item->type == 3)
        <a class="dropdown-item d-flex align-items-center" href="{{route('notification.pembelian', $item->id)}}">
        @endif
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    @if($item->type == 1)
                    <i class="fas fa-egg text-white"></i>
                    @else
                    <i class="fas fa-receipt text-white"></i>
                    @endif
                </div>
            </div>
            <div>
                <div class="small text-gray-500">{{date('d/m/Y', strtotime($item->created_at))}}</div>
                <span class="@if($item->read == 1) font-weight-bold @endif">{{$item->title}} {{$item->getContent()}}</span>
            </div>
        </a>
        @endforeach
    </div>
</li>