@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-xl-6 col-lg-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div style="padding: 3rem 3rem;">
                    <div class="text-center">
                        <img src="{{asset('cancel.png')}}" alt="">
                        <h1 class="h4 text-green-900 mb-4" style="color: red">Username atau Password Salah!</h1>
                        {{-- <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }} --}}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                        <a href="{{ route('login') }}" class="btn btn-primary">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
