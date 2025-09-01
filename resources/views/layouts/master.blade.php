<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <!--! The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags !-->
    <!--! BEGIN: Apps Title-->
    <title>Badar & Bros - Portal</title>
    <!--! END:  Apps Title-->
    <!--! BEGIN: Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/images/favicon.ico') }}">
    <!--! END: Favicon-->
    <!--! BEGIN: Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}">
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/css/dataTables.bs5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/vendors/css/select2-theme.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ url('assets/vendors/sweetalert2/sweetalert2.css') }}" /> --}}

    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/theme.min.css') }}">
    <!--! END: Custom CSS-->

</head>

<body>
    <!-- Menu -->
    @include('layouts.webmenu')
    <!-- / Menu -->

    @include('layouts.navbar')

    <!-- / Navbar -->

    <!-- Content wrapper -->

    @yield('content')
    <!-- Footer -->
    @include('layouts.footer')
    <!-- / Footer -->

    <!-- / Layout page -->

    <!--! BEGIN: Vendors JS !-->
    <script src="{{ url('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="{{ url('assets/js/common-init.min.js') }}"></script>
    <script src="{{ url('assets/vendors/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ url('assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ url('assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ url('assets/vendors/js/select2-active.min.js') }}"></script>
    <script src="{{ url('assets/js/customers-init.min.js') }}"></script>
    <script src="{{ url('assets/vendors/sweetalert2/sweetalert2.js') }}"></script>
    {{-- <script src="{{ url('assets/js/extended-ui-sweetalert2.js') }}"></script> --}}
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="{{ url('assets/js/theme-customizer-init.min.js') }}"></script>
    <!--! END: Theme Customizer !-->

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.bootstrap5.min.js"></script>

    <!-- Export Requirements -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- HTML5 & Print -->
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.colVis.min.js"></script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: {!! json_encode(session('success')) !!},
                showConfirmButton: false,
                timer: 2500
            }).then(() => {
                @php
                    session(['success' => null]);
                @endphp
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: {!! json_encode(session('error')) !!},
                showConfirmButton: false,
                timer: 2500
            }).then(() => {
                @php
                    session(['error' => null]);
                @endphp
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: {!! json_encode($error) !!},
                    showConfirmButton: false,
                    timer: 2500
                });
            </script>
        @endforeach
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('fullscreen-toggle');
            const maximizeIcon = btn.querySelector('.maximize');
            const minimizeIcon = btn.querySelector('.minimize');

            function isFullScreen() {
                return document.fullscreenElement || document.webkitFullscreenElement || document
                    .mozFullScreenElement || document.msFullscreenElement;
            }

            function updateIcons() {
                if (isFullScreen()) {
                    maximizeIcon.style.display = 'none';
                    minimizeIcon.style.display = '';
                } else {
                    maximizeIcon.style.display = '';
                    minimizeIcon.style.display = 'none';
                }
            }

            btn.addEventListener('click', function() {
                if (!isFullScreen()) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.msRequestFullscreen) {
                        document.documentElement.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
            });

            document.addEventListener('fullscreenchange', updateIcons);
            document.addEventListener('webkitfullscreenchange', updateIcons);
            document.addEventListener('mozfullscreenchange', updateIcons);
            document.addEventListener('MSFullscreenChange', updateIcons);
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault(); // stop the default form submit

                let form = $(this).closest('form'); // get the form to submit later

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // proceed with deletion
                    }
                });
            });
            $(".datatable").DataTable({
                pageLength: 10,
                lengthMenu: [10, 20, 50, 100, 200, 500],
                layout: {
                    topStart: {
                        buttons: [{
                                extend: 'copy'
                            },
                            {
                                extend: 'csv'
                            },
                            {
                                extend: 'excel'
                            },
                            {
                                extend: 'pdf'
                            },
                            {
                                extend: 'print'
                            },
                            {
                                extend: 'colvis'
                            }
                        ]
                    }
                }
            });
        });
    </script>

</body>

</html>
