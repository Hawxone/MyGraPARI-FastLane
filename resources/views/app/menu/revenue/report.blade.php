@extends('layouts.app')

@section('content')
    <!-- Datatables -->
    <script src="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.js') }}"></script>
    <link href="{{ asset('vendor/plugin/datatables/DataTables-1.10.20/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

    <div class="container">
        <div class="card-columns">
            <div class="card">
                <div class="card-header">Revenue Bulan Ini</div>
                <div class="card-body">
                    <b>Total Revenue bulan ini : </b><a id="val"></a> <br>
                    <b>Jumlah Transaksi bulan ini : {{ $data['count'] }}</b>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Revenue Hari Ini</div>
                <div class="card-body">
                    <b>Total Revenue hari ini : </b><a id="val2"></a> <br>
                    <b>Jumlah Transaksi hari ini : {{ $data['count2'] }}</b>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Outlook Revenue Bulan Ini</div>
                <div class="card-body">
                    <b>Outlook : </b><a id="val3"></a> <br>

                </div>
            </div>


        </div>

        <div class="card" style="margin-top: 20px;">
            <div class="card-header">Revenue Detail</div>

            <div class="card-body">
                <div style="margin-bottom: 30px;">
                    <form method="POST" action="#">
                        @csrf
                        <input type="hidden" class="form-control" value="{{ Auth::user()->username }}" name='username' id="username">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="bulan">Bulan </label>
                                <select class="form-control" id="bulan">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="nama">Tahun </label>
                                <select class="form-control" id="tahun">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                </select>
                            </div>

                            <div class="form-group col-md-1" style="margin-top: 8px;">
                                <label></label>
                                <button type="button" id="submit" class="form-control btn btn-primary">submit</button>

                            </div>


                        </div>
                    </form>
                </div>
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
                    @foreach($data['revenues'] as $row)
                        <tr>
                            <td>{{ substr($row->created,0,10) }}</td>
                            <td>{{ $row->nigga }}</td>
                            <td>{{ $row->msisdn }}</td>
                            <td>{{ $row->reason }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->revenue }}</td>
                            <td>{{ $row->notes }}</td>
                            <td><a href="#">Ubah </a><a href="#">Hapus</a></td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>


        </div>
    </div>

    <script>
        var table = $('#table').DataTable();
        $(document).ready( function () {


            let value ={{ $data['total'] }};
            let value2 ={{ $data['today'] }};
            let value3 ={{ $data['outlook'] }};
            let num = value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            let num2 = value2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            let num3 = value3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            console.log(num);
            $('#val').text('Rp. '+num);
            $('#val2').text('Rp. '+num2);
            $('#val3').text('Rp. '+num3);

        } );


        $(document).on('click','#submit', function () {

            table.clear().draw();
            $('#tab').empty();
            $.ajax({
                url:'{{ route('revenue.showdate', ['username'=>Auth::user()->username]) }}',
                type: 'GET',
                dataType:'JSON',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'username' : $('#username').val(),
                    'tahun' : $('#tahun').val(),
                    'bulan' : $('#bulan').val()
                },
                success : function (data) {
                    console.log(data)

                    $.each(data, function (key, value) {
                        table.row.add([ data[key].created,data[key].nigga, data[key].msisdn, data[key].reason,data[key].nama,data[key].revenue,data[key].notes,'<a href="#">Ubah </a><a href="#">Hapus</a>' ]);

                    });

                    table.draw();


                }
            })

        })
    </script>

@endsection

