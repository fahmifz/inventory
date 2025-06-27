@extends('layouts.auth', ['title' => 'Register'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css')}}">
    @endpush

    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form action="{{route('admin.registersubmit')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-6">
                        <label for="first_name">First Name</label>
                        <input id="first_name" type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Username</label>
                    <input id="username" type="text" class="form-control" name="username">
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="password" class="d-block">Password</label>
                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                            name="password">
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="password2" class="d-block">Password Confirmation</label>
                        <input id="password2" type="password" class="form-control" name="password-confirm">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('library/jquery-pwstrength/pwstrength.js')}}"></script>
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js')}}"></script>
        <script src="{{ asset('js/page/auth-register.js')}}"></script>
        <!-- SweetAlert2 CDN -->
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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