@extends('layouts.app')

@section('content')

    <div class="container">
        <table class="table table-bordered" style="text-align: center;">
            <thead>
                <tr>
                    <th>Total Issued</th>
                    <th>Waiting</th>
                    <th>Serving</th>
                    <th>Served</th>
                    <th>Unserved</th>
                    <th>Average Serving Time</th>
                    <th>Average Waiting Time</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><a href="{{ route('monitoring.issued') }}" style="text-decoration: underline;">{{ $data['issued'] }}</a></td>
                    <td><a href="{{ route('monitoring.waiting') }}" style="text-decoration: underline;">{{ $data['waiting'] }}</a></td>
                    <td><a href="{{ route('monitoring.serving') }}" style="text-decoration: underline;">{{ $data['serving'] }}</a></td>
                    <td><a href="{{ route('monitoring.served') }}" style="text-decoration: underline;">{{ $data['served'] }}</a></td>
                    <td><a href="{{ route('monitoring.unserved') }}" style="text-decoration: underline;">{{ $data['unserved'] }}</a></td>
                    <td>{{ $data['time'] }}</td>
                    <td>{{ $data['wt'] }}</td>
                </tr>
            </tbody>

        </table>
    </div>

    @endsection
