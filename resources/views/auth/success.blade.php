@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-xl-6 col-lg-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div style="padding: 3rem 3rem;">
                    <div class="text-center">
                        <img src="{{asset('success.png')}}" alt="">
                        <h1 class="h4 text-green-900 mb-4" style="color: #64DD9E">Selamat Datang!</h1>
                        <a href="{{ route('home') }}" class="btn btn-primary">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
