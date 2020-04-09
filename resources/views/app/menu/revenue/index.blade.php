@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="container">
        <div class="card">
            <div class="card-header">Revenue Input</div>

            <div class="card-body">
                <form  method="POST" id="form" action="{{ route('revenue.store') }}">
                    @csrf
                    <input type="hidden" name="username" value="{{ Auth::user()->username }}">
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="nama">Nama Pelanggan </label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pelanggan" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputState">Case</label>
                            <select id="inputState" name="reason" class="form-control" required>
                                <option selected>Pilih...</option>
                                <option value="GANTI KARTU">GANTI KARTU</option>
                                <option value="RECHARGE">RECHARGE</option>
                                <option value="PSB HALO">PSB HALO</option>
                                <option value="GANTI PAKET HALO UPGRADE">GANTI PAKET HALO UPGRADE</option>
                                <option value="GANTI PAKET HALO DOWNGRADE">GANTI PAKET HALO DOWNGRADE</option>
                                <option value="REAKTIVASI HALO">REAKTIVASI HALO</option>

                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="msisdn">MSISDN</label>
                            <input type="text" class="form-control" name="msisdn" id="msisdn" placeholder="MSISDN" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="notes">Notes</label>
                            <input type="text" class="form-control" name="notes" id="notes" placeholder="notes">
                        </div>


                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="revenue">Revenue</label>
                            <input type="number" class="form-control" name="revenue" id="revenue" placeholder="Revenue" required>
                        </div>


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
            <div class="card-header">List Revenue Hari Ini</div>
            <div class="card-body">

                <table id="table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>MSISDN</th>
                        <th>Case</th>
                        <th>CSR</th>
                        <th>Revenue</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody id="tab">
                    @foreach($data['join'] as $row)
                        <tr>
                            <td>{{ substr($row->created,0,10) }}</td>
                            <td>{{ $row->nigga }}</td>
                            <td>{{ $row->msisdn }}</td>
                            <td>{{ $row->reason }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->revenue }}</td>
                            <td>{{ $row->notes }}</td>
                            <td><a href="">Ubah </a><a href="{{ route('revenue.delete',['username'=>Auth::user()->username,'id'=>$row->id]) }}">Hapus</a></td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>


@endsection
