@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">Waiting</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>MSISDN</th>
                        <th>Group</th>
                        <th>Issued</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $x = 1 ?>
                    @foreach($waiting as $i)
                        <tr>
                            <td>{{ $i->nomor_antrian }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ $i->msisdn_1 }}</td>
                            <td>{{ $i->keluhan }}</td>
                            <td>{{ $i->issued }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
