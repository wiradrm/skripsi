@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-xl-6 col-lg-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div style="padding: 3rem 3rem;">
                    <img src="{{asset('logo-lpd.png')}}" alt="LPD Benana" style="border-radius: 100%; width: 160px; height: 130px; margin: 0 auto 20px; display: block;">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Sistem Informasi Pelayanan <br> Lembaga Perkreditan Desa <br> Pakraman Benana</h1>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="username" type="text" class="form-control form-control-user @error('email') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="Username" autofocus placeholder="Username">
                            @error('username')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <div class="custom-control custom-checkbox small">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="custom-control-input" id="customCheck">
                                <label style="line-height: 25px" class="custom-control-label" for="customCheck">Remember
                                    Me</label>
                            </div> --}}
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
