@extends('layouts.admin')
@section('title')
    Penjualan
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penjualan</h1>
    <div class="row my-4">
        <div class="col-md-6">
            <div class="d-flex justify-content-start">
                @if (Auth::user()->level === 1)
                    <button type="submit" data-target="#createModalToko" data-toggle="modal" class="btn btn-primary">Tambah
                        Penjualan Toko</button>
                @endif
                <button type="submit" data-target="#createModal" data-toggle="modal" class="ml-1 btn btn-success">Tambah
                    Penjualan</button>
            </div>
        </div>
    </div>
    <form class="form-row mb-4" action="{{ route('penjualan') }}" method="GET">
        <div class="form-group my-0 col-md">
            <label for="from" class="col-form-label">Dari</label>
            <input type="date" class="form-control" id="from" name="from">
        </div>
        <div class="form-group my-0 col-md">
            <label for="to" class="col-form-label">Sampai</label>
            <input type="date" class="form-control" id="to" name="to">
        </div>
        <div class="form-group my-0 col-md">
            <label for="status_pembayaran" class="col-form-label">Status Pembayaran</label>
            <select class="form-control" name="status_pembayaran" id="status_pembayaran">
                <option @if (request()->query('status_pembayaran') == 1) selected @endif value="1">Lunas</option>
                <option @if (request()->query('status_pembayaran') == 2) selected @endif value="2">Hutang</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
            <a href="{{ route('penjualan') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
        </div>
    </form>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
        </div>
        <div class="card-body">
            @if (\Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! \Session::get('info') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (\Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! \Session::get('error') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="my-0 px-4">
                        @foreach ($errors->all() as $error)
                            <li class="my-0">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            @if (Auth::user()->level == 2)
                                <th>Toko</th>
                            @endif
                            <th>Pelanggan</th>
                            <th>Jenis Telur</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Sub Total</th>
                            <th>Pembayaran</th>
                            <th>Dibayar</th>
                            <th>Kembalian</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($models->count() == 0)
                            <tr>
                                <td colspan="100%" align="center">
                                    No data
                                </td>
                            </tr>
                        @endif
                        @foreach ($models as $key => $item)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                @if (Auth::user()->level == 2)
                                    <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
                                @endif
                                <td>{{ $item->customer }}</td>
                                <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->getJenisTelur->jenis_telur : '' }}
                                </td>
                                <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->showJumlah() : '' }}</td>
                                <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->satuan : '' }}</td>
                                <td>@currency($item->harga)</td>
                                <td>@currency($item->subtotal)</td>
                                <td>
                                    @if ($item->status_pembayaran === 1)
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($item->status_pembayaran === 2)
                                        <span class="badge badge-danger">Hutang</span>
                                    @endif
                                </td>
                                <td>@currency($item->paid)</td>
                                <td>
                                    @if ($item->change < 0)
                                        @currency(0)
                                    @else
                                        @currency($item->change)
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-circle btn-danger" href="#" data-toggle="modal"
                                        data-target="#deleteModal-{{ $item->id }}"><i class='bx bxs-trash-alt'></i></a>
                                    @if ($item->getTelurKeluar ? $item->getTelurKeluar->id_toko_tujuan : '')
                                        <a class="btn btn-circle btn-info mx-1" href="#" data-toggle="modal"
                                            data-target="#updateModalToko-{{ $item->id }}"><i
                                                class='bx bxs-edit'></i></a>
                                    @else
                                        <a class="btn btn-circle btn-info mx-1" href="#" data-toggle="modal"
                                            data-target="#updateModal-{{ $item->id }}"><i class='bx bxs-edit'></i></a>
                                    @endif
                                    <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">Apakah anda yakin menghapus data
                                                    "{{ $item->getTelurKeluar ? $item->getTelurKeluar->getJenisTelur->jenis_telur : '' }}"
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Cancel</button>
                                                    <a href="{{ route('penjualan.destroy', $item->id) }}"
                                                        class="btn btn-primary">
                                                        Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('admin.penjualan.update')
                                </td>
                            </tr>
                            @include('admin.penjualan.updatetoko')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('admin.penjualan.create')
    </div>
    @if (Auth::user()->level === 1)
        @include('admin.penjualan.createtoko')
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#satuan_create").on("input", function() {
                if($(this).val() == "Butir"){
                    $("#subtotalWrapper").hide();
                }
                if($(this).val() == "Tray"){
                    $("#subtotalWrapper").show();
                }
            });
        });
        $(document).ready(function() {
            $("#satuan_create_toko").on("input", function() {
                if($(this).val() == "Butir"){
                    $("#subtotalTokoWrapper").hide();
                }
                if($(this).val() == "Tray"){
                    $("#subtotalTokoWrapper").show();
                }
            });
        });
        // GET SUBTOTAL

        $(document).ready(function() {
            $("#createinputpaidtoko").on("input", function() {
                var harga = $("#setHargaToko").val()
                var jumlah = $("#createJumlahToko").val()
                var kembalian
                if($("#satuan_create_toko").val() == "Tray"){
                    kembalian = $(this).val() - (harga * jumlah)
                }
                if($("#satuan_create_toko").val() == "Butir"){
                    kembalian = $(this).val() - harga
                }
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(kembalian)
                $("#changeToko").text(output)
            });
        });
        // GET SUBTOTAL
        $(document).ready(function() {
            $("#createJumlahToko").on("input", function() {
                var harga = $("#setHargaToko").val();
                var jumlah = $(this).val();

                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotalToko").text(output);
            });
            $("#jenisTelurToko").on("input", function() {
                var val = $(this).val();
                @foreach ($harga as $key => $data)
                    if (val == {{ $data->id_jenis_telur }}) {
                        var harga = {{ $data->harga_jual_per_tray }};
                    }
                @endforeach
                var jumlah = $("#createJumlahToko").val();
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotalToko").text(output);
            });
            $("#setHargaToko").on("input", function() {
                var jumlah = $("#createJumlahToko").val();
                var harga = $(this).val();
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotalToko").text(output);
            });
        });

        // GET SUBTOTAL
        $(document).ready(function() {
            $("#createinputpaid").on("input", function() {
                var jumlah = $("#createJumlah").val();
                var harga = $("#setHargaGudang").val();
                var kembalian
                if($("#satuan_create").val() == "Tray"){
                    kembalian = $(this).val() - (harga * jumlah)
                }
                if($("#satuan_create").val() == "Butir"){
                    kembalian = $(this).val() - harga
                }
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(kembalian);
                $("#change").text(output);
            });
        });
        // GET SUBTOTAL
        $(document).ready(function() {
            $("#createJumlah").on("input", function() {
                var harga = $("#setHargaGudang").val();
                var jumlah = $(this).val();

                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotal").text(output);
            });
            $("#jenisTelur").on("input", function() {
                var val = $(this).val();
                @foreach ($harga as $key => $data)
                    if (val == {{ $data->id_jenis_telur }}) {
                        var harga = {{ $data->harga_jual_per_tray }};
                    }
                @endforeach
                var jumlah = $("#createJumlah").val();
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotal").text(output);
            });
            $("#setHargaGudang").on("input", function() {
                var jumlah = $("#createJumlah").val();
                var harga = $(this).val();
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(harga * jumlah);
                $("#subtotal").text(output);
            });
        });
        // SET HARGA
        $(function() {
            @foreach ($harga as $key => $data)
                var harga_{{ $data->id_jenis_telur }} = {{ $data->harga_jual_per_tray }}
                if ($("#jenisTelur").val() == {{ $data->id_jenis_telur }}) {
                    $("#setHargaGudang").val(harga_{{ $data->id_jenis_telur }})
                }
            @endforeach
            $("#jenisTelur").change(function() {
                var val = $(this).val();
                @foreach ($harga as $key => $data)
                    if (val == {{ $data->id_jenis_telur }}) {
                        $("#setHargaGudang").val(harga_{{ $data->id_jenis_telur }})
                    }
                @endforeach
            });
        });
        // SET HARGA
        $(function() {
            @foreach ($harga as $key => $data)
                var harga_{{ $data->id_jenis_telur }} = {{ $data->harga_gudang_per_tray }}
                if ($("#jenisTelurToko").val() == {{ $data->id_jenis_telur }}) {
                    $("#setHargaToko").val(harga_{{ $data->id_jenis_telur }})
                }
            @endforeach
            $("#jenisTelurToko").change(function() {
                var val = $(this).val();
                @foreach ($harga as $key => $data)
                    if (val == {{ $data->id_jenis_telur }}) {
                        $("#setHargaToko").val(harga_{{ $data->id_jenis_telur }})
                    }
                @endforeach
            });
        });
        // SET STATUS
        $(function() {
            $("#hutangToko").hide();
            $("#createStatusPembayaranToko").change(function() {
                console.log("cange")
                var val = $(this).val();
                if (val == 2) {
                    $("#hutangToko").show();
                } else if (val == 1) {
                    $("#hutangToko").hide();
                }
            });
        });

        $(function() {
            $("#hutang").hide();
            $("#createStatusPembayaran").change(function() {
                var val = $(this).val();
                if (val == 2) {
                    $(".create_customer_hutang").show();
                    $(".create_input_customer_hutang").hide();
                    $("#hutang").show();
                    $("#paid").hide();
                } else if (val == 1) {
                    $(".create_customer_hutang").hide();
                    $(".create_input_customer_hutang").show();
                    $("#hutang").hide();
                    $("#paid").show();
                }
            });
        });

        $(function() {
            $("#hutangToko").hide();
            $("#createStatusPembayaranToko").change(function() {
                console.log("cange")
                var val = $(this).val();
                if (val == 2) {
                    $("#hutangToko").show();
                    $("#paidtoko").hide();
                } else if (val == 1) {
                    $("#hutangToko").hide();
                    $("#paidtoko").show();
                }
            });
        });

        $(function() {
            $(".updateHutang").hide();
            $(".updateStatusPembayaran").change(function() {
                var val = $(this).val();
                if (val == 2) {
                    $(".update_customer_hutang").show();
                    $(".update_input_customer_hutang").hide();
                    $(".updateHutang").show();
                    $(".paid").hide();
                } else if (val == 1) {
                    $(".update_customer_hutang").hide();
                    $(".update_input_customer_hutang").show();
                    $(".updateHutang").hide();
                    $(".paid").show();
                }
            });
        });

        $(document).ready(function() {
            $(".create_customer_hutang").hide();

            $.each($(".checkStatusPembayaran"), function(index, value) {
                var val = $(value).find(".updateStatusPembayaran").val();
                if (val == 2) {
                    $(value).find(".updateHutang").show();
                    $(value).find(".paid").hide();
                    $(".update_customer_hutang").show();
                    $(".update_input_customer_hutang").hide();
                } else if (val == 1) {
                    $(".update_customer_hutang").hide();
                    $(".update_input_customer_hutang").show();
                    $(value).find(".updateHutang").hide();
                    $(value).find(".paid").show();
                }
            });
        });
    </script>
@endsection
