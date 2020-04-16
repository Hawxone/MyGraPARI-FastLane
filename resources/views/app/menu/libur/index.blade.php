@extends('layouts.app')

@section('content')
    <!-- Datatables -->
    <script src="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.js') }}"></script>
    <link href="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Libur</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form  method="POST" id="form" action="{{ route('libur.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Tanggal </label>
                                    <input type="date" class="form-control" name="date" id="date" placeholder="Nama Pelanggan" required>
                                </div>

                                <button type="submit" id="submit" class="btn btn-primary" style="width: 100%;"><i id="spinner" class="fa fa-spinner fa-spin" style="display: none;"></i> Submit</button>
                                <script>

                                    $('#form').on('submit',function () {
                                        $('#submit').attr('disabled',true);
                                        $('#spinner').show();
                                    })

                                </script>

                            </form>


                    </div>
                </div>

                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">Jadwal Libur</div>
                    <div class="card-body">
                        <form method="post" action="#">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($libur as $l)
                                <tr>
                                    <td>{{ $l->id }}</td>
                                    <td>{{ $l->date }}</td>
                                    <td><a href="{{ route('libur.destroy',['id'=>$l->id]) }}"><i class="fas fa-window-close"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
