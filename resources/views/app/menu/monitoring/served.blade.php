@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">Served</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>MSISDN</th>
                        <th>Group</th>
                        <th>Ambassador</th>
                        <th>Issued</th>
                        <th>Dipanggil</th>
                        <th>Selesai</th>
                        <th>Durasi</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $x = 1 ?>
                    @foreach($served as $i)
                        <tr>
                            <td>{{ $i->nomor_antrian }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ $i->msisdn_1 }}</td>
                            <td>{{ $i->keluhan }}</td>
                            <td>{{ $i->ambassador }}</td>
                            <td>{{ $i->issued }}</td>
                            <td>{{ $i->dipanggil }}</td>
                            <td>{{ $i->selesai }}</td>
                            <?php
                            $start =  \Carbon\Carbon::parse($i->selesai);
                            $end = \Carbon\Carbon::parse($i->dipanggil);
                            $hours = $end->diffInHours($start);
                            $minutes = $end->diffInMinutes($start);
                            $seconds = $end->diffInSeconds($start);
                            ?>
                            <td>{{ $hours }}:{{ $minutes }}:{{ $seconds }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

