<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>{{ $title }} &mdash; INVENTORI</title>

    <!-- General CSS -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @stack('styles')
</head>

<body class="{{ $title == 'Layout Transparent' ? 'layout-2' : ($title == 'Layout Top Navigation' ? 'layout-3' : '') }}">

    <div id="app">
        <div class="main-wrapper {{ $title == 'Layout Top Navigation' ? 'container' : '' }}">

            {{-- Header & Sidebar --}}
            @if ($title == 'Layout Transparent')
                @include('components.transparent.header')
                @include('components.transparent.sidebar')
            @elseif ($title == 'Layout Top Navigation')
                @include('components.top-navigation.navbar')
            @else
                @include('components.default.header')
                @include('components.default.sidebar')
            @endif

            {{-- Main Content --}}
            @yield('content')

            {{-- Footer --}}
            @include('components.footer')

        </div>
    </div>

    <!-- General JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Plugin JS -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
    {{-- <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script> --}}
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Template JS -->
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')

    {{-- ============================================
        ALERT SYSTEM (Switch Version)
    ============================================= --}}
    @php $msg = session('message'); @endphp

    @switch($msg)
        @case('username sudah ada')
            <script> swal("Warning", "Username sudah terdaftar", "error"); </script>
        @break

        @case('store')
            <script> swal("Berhasil", "Berhasil tambah data", "success"); </script>
        @break

        @case('update')
            <script> swal("Berhasil", "Berhasil update data", "success"); </script>
        @break

        @case('size gambar')
            <script> swal("Error", "Gambar harus jpg/png/jpeg minimal 512kb", "error"); </script>
        @break

        @case('size bukti')
            <script> swal("Error", "File bukti harus PDF minimal 1.5MB", "error"); </script>
        @break

        @case('error form')
            <script> swal("Warning", "Ada kesalahan dalam pengisian form", "warning"); </script>
        @break

        @case('error nik')
            <script> swal("Error", "NIK atau NIP sudah terdaftar", "error"); </script>
        @break

        @case('error golongan')
            <script> swal("Error", "Golongan tidak valid", "error"); </script>
        @break

        @case('stok error')
            <script> swal("Error", "Jumlah tidak sesuai stok barang", "error"); </script>
        @break

        @case('gagal login')
            <script> swal("Warning", "Username atau password salah", "error"); </script>
        @break

        @case('sukses login')
            <script> swal("Berhasil", "Login berhasil", "success"); </script>
        @break

        @case('need login')
            <script> swal("Warning", "Anda harus login terlebih dahulu", "error"); </script>
        @break

        @case('update profile')
            <script> swal("Berhasil", "Profile berhasil diupdate, silahkan login ulang", "success"); </script>
        @break

        @case('error surat')
            <script> swal("Error", "Tidak ada data honor kegiatan", "error"); </script>
        @break

        @case('error suratk')
            <script> swal("Error", "Tidak ada data kuitansi kegiatan", "error"); </script>
        @break
    @endswitch

    {{-- Fix Modal Bug di Stisla --}}
    <script>
        $(document).on('show.bs.modal', function () {
            $('.main-wrapper').css('transform', 'none');
        });
        $(document).on('hidden.bs.modal', function () {
            $('.main-wrapper').removeAttr('style');
        });
    </script>
    @if (session('message') == 'logout')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Logout',
            text: 'Anda telah keluar dari sistem',
            confirmButtonColor: '#48c2f6'
        });
    </script>
    @endif

</body>

</html>
