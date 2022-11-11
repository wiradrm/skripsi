@php($profile = App\User::where('id', Auth::user()->id)->first())
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title') - Sari Nadi</title>
    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"
        integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin-2.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}" type="image/x-icon">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <span>Sari Nadi</span>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class='bx bxs-bar-chart-alt-2'></i>
                    <span>Home</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            @if (Auth::user()->level != 2)
                <li class="nav-item {{ Request::routeIs('stock') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock"
                        aria-expanded="true" aria-controls="collapseStock">
                        <i class='bx bxs-dashboard'></i>
                        <span>Stock</span>
                    </a>
                    <div id="collapseStock" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('stock') }}">All</a>
                            @php($jenistelur = App\JenisTelur::all())
                            @foreach ($jenistelur as $key => $item)
                                <a class="collapse-item"
                                    href="{{ route('stock', ['jenis_telur' => $item->id]) }}">{{ $item->jenis_telur }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif
            @if (Auth::user()->level == 1)
                <li
                    class="nav-item {{ Request::routeIs('user', 'jenis_telur', 'toko_gudang', 'jenis_kandang') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class='bx bxs-dashboard'></i>
                        <span>Master Data</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Data Mapping:</h6> -->
                            <a class="collapse-item" href="{{ route('user') }}">User</a>
                            <a class="collapse-item" href="{{ route('customer') }}">Customer</a>
                            <a class="collapse-item" href="{{ route('jenis_telur') }}">Jenis Telur</a>
                            <a class="collapse-item" href="{{ route('jenis_kandang') }}">Jenis Kandang</a>
                            <a class="collapse-item" href="{{ route('toko_gudang') }}">Toko dan Gudang</a>
                        </div>
                    </div>
                </li>
            @endif
            @if (Auth::user()->level == 1)
                <li class="nav-item {{ Request::routeIs('manajemen_ayam', 'efektivitas_bertelur') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManajemenKandang"
                        aria-expanded="true" aria-controls="collapseManajemenKandang">
                        <i class='bx bxs-dashboard'></i>
                        <span>Manajemen Kandang</span>
                    </a>
                    <div id="collapseManajemenKandang" class="collapse" aria-labelledby="headingManajemenKandang"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Data Mapping:</h6> -->
                            <a class="collapse-item" href="{{ route('manajemen_ayam') }}">Manajemen Ayam</a>
                            <a class="collapse-item" href="{{ route('efektivitas_bertelur') }}">Efektivitas Bertelur</a>
                        </div>
                    </div>
                </li>
            @endif
            @if (Auth::user()->level == 1)
            <li class="nav-item {{ Request::routeIs('stock_in', 'stock_kandang') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManajemenTelur"
                    aria-expanded="true" aria-controls="collapseManajemenTelur">
                    <i class='bx bxs-dashboard'></i>
                    <span>Manajemen Telur</span>
                </a>
                <div id="collapseManajemenTelur" class="collapse" aria-labelledby="headingManajemenTelur"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Data Mapping:</h6> -->
                        <a class="collapse-item" href="{{ route('stock_in') }}">Telur Masuk</a>
                        <a class="collapse-item" href="{{ route('stock_kandang') }}">Telur Kandang</a>
                    </div>
                </div>
            </li>
        @endif
            @if (Auth::user()->level == 2)
                <li class="nav-item {{ Request::routeIs('user') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user') }}">
                        <i class='bx bxs-dashboard'></i>
                        <span>User</span></a>
                </li>
            @endif
            @if (Auth::user()->level == 0)
            <li class="nav-item {{ Request::routeIs('customer') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('customer') }}">
                    <i class='bx bxs-dashboard'></i>
                    <span>Customer</span></a>
            </li>
            @endif
            @if (Auth::user()->level != 2)
                <li class="nav-item {{ Request::routeIs('harga') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('harga') }}">
                        <i class='bx bxs-dashboard'></i>
                        <span>Harga</span></a>
                </li>
            @endif
            @if (Auth::user()->level != 2)
                <li
                    class="nav-item {{ Request::routeIs('stock_out', 'penjualan', 'pembelian', 'pengeluaran', 'hutang') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
                        aria-expanded="true" aria-controls="collapseUtilities2">
                        <i class='bx bxs-dashboard'></i>
                        <span>Transaksi</span>
                    </a>
                    <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Data Mapping:</h6> -->
                            <a class="collapse-item" href="{{ route('pembelian') }}">Pembelian</a>
                            <a class="collapse-item" href="{{ route('penjualan') }}">Penjualan</a>
                            <a class="collapse-item" href="{{ route('pengeluaran') }}">Pengeluaran</a>
                            <a class="collapse-item" href="{{ route('hutang') }}">Hutang</a>
                        </div>
                    </div>
                </li>
            @endif
            <li
                class="nav-item {{ Request::routeIs('laporan.labarugi','laporan.penjualan','laporan.pembelian','laporan.pengeluaran','laporan.hutang','laporan.harga','laporan.stock','laporan.stock_in','laporan.stock_out')? 'active': '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3"
                    aria-expanded="true" aria-controls="collapseUtilities3">
                    <i class='bx bxs-dashboard'></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Data Mapping:</h6> -->
                        <a class="collapse-item" href="{{ route('laporan.labarugi') }}">Laporan Laba/Rugi</a>
                        <a class="collapse-item" href="{{ route('laporan.penjualan') }}">Laporan Penjualan</a>
                        <a class="collapse-item" href="{{ route('laporan.pembelian') }}">Laporan Pembelian</a>
                        <a class="collapse-item" href="{{ route('laporan.pengeluaran') }}">Laporan Pengeluaran</a>
                        <a class="collapse-item" href="{{ route('laporan.hutang') }}">Laporan Hutang</a>
                        <a class="collapse-item" href="{{ route('laporan.harga') }}">Laporan Harga</a>
                        <a class="collapse-item" href="{{ route('laporan.stock') }}">Laporan Stok</a>
                        @if (Auth::user()->level !== 0)
                        <a class="collapse-item" href="{{ route('laporan.efektivitas_bertelur') }}">Laporan Efektivitas</a>
                        <a class="collapse-item" href="{{ route('laporan.stock_kandang') }}">Laporan Telur Kandang</a>
                        <a class="collapse-item" href="{{ route('laporan.stock_in') }}">Laporan Telur Masuk</a>
                        @endif
                    </div>
                </div>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        @include('admin.notification.notification')
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?background=eb4d4b&color=ffffff&name={{ Auth::user()->name }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfileModal">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sari Nadi 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg text-left" id="editProfileModal" tabindex="-1" role="dialog"
        aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.update', Auth::user()->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="level" name="level"
                            value="{{ $profile->level }}">
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="name"
                                value="{{ $profile->name }}">
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ $profile->username }}">
                        </div>
                        <div class="form-group">
                            <label for="no_telpon" class="col-form-label">No Telpon</label>
                            <input type="text" class="form-control" id="no_telpon" name="no_telpon"
                                value="{{ $profile->no_telpon }}">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label">New Password Confirmation</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" autocomplete="false">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sb-admin-2.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"
        integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [3, "desc"]
                ], //or asc 
                "columnDefs": [{
                    "targets": 3,
                    "type": "date-eu"
                }],
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: "{{ route('notification.checkhutang') }}",
                type: "GET",
                async: false,
                data: {

                },
                success: function() {
                    console.log("notification updated");
                }
            });
        });

        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
    @php($notif = App\Notification::where('id_toko_gudang', Auth::user()->id_toko_gudang)->get())
    @foreach ($notif as $key => $item)
        @if ($item->type == 1)
            @include('admin.notification.accept')
        @endif
    @endforeach
</body>

</html>
