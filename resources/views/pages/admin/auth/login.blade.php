@extends('layouts.auth', ['title' => 'Login'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
        <!-- SweetAlert2 CDN -->
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{route('admin.login_proses')}}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="email">Username</label>
                    <input id="email" type="username" class="form-control" name="username" tabindex="1" required
                        autofocus>
                    <div class="invalid-feedback">
                        Please fill in your username
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        {{-- <div class="float-right">
                            <a href="#" class="text-small">
                                Forgot Password?
                            </a>
                        </div> --}}
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                        please fill in your password
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Login Sebagai</label>
                    </div>
                    <select class="form-control  selectric" name="role" id="">
                        <option value="">-- Pilih Role --</option>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>


        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        <a href="{{route('admin.register')}}">Kembali ke beranda</a>
    </div>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>


    @push('scripts')
     @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#48c2f6'
                });
            </script>
         @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#f27474'
                });
            </script>
        @endif  
    @endpush
@endsection