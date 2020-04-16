@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body mx-auto">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        @canany(['spv','csr','admin'], auth()->user())
                            <a href="{{ route('ambassador.index') }}"><button class="btn btn-danger">Ambassador</button></a>
                            <a href="{{ route('navigator.index') }}"><button class="btn btn-danger">Navigator</button></a>
                            <a href="{{ route('revenue.index',['username'=>Auth::user()->username]) }}"><button class="btn btn-danger">Revenue</button></a>
                        @endcan

                        @canany(['admin'], auth()->user())
                            <a href="{{ route('libur.index') }}"><button class="btn btn-danger">Jadwal Libur</button></a>
                        @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
