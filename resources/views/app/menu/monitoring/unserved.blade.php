@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">Unserved</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Group</th>
                        <th>Dipanggil</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $x = 1 ?>
                    @foreach($unserved as $i)

                        <tr>
                            <td>{{ $i->nomor_antrian }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ $i->keluhan }}</td>
                            <td>{{ $i->dipanggil }}</td>
                            <td>{{ $i->keterangan }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

