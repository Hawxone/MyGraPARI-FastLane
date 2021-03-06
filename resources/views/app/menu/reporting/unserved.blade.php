@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Reporting Unserved</div>

            <div class="card-body">
                <form method="POST" action="{{ route('reporting.export_unserved') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="nama">From </label>
                        <input type="date" class="form-control" name='date' id="date">
                    </div>

                    <div class="form-group col-md-3">
                        <label>To</label>
                        <input type="date" class="form-control" name="date2" id="date2" >
                    </div>

                    <div class="form-group col-md-1" style="margin-top: 8px;">
                        <label></label>
                        <button type="button" id="submit" class="form-control btn btn-primary">submit</button>

                    </div>

                    <div class="form-group col-md-1" style="margin-top: 8px;">
                        <label></label>
                        <button type="submit" class="form-control btn btn-primary">Export</button>

                    </div>

                </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>MSISDN 1</th>
                        <th>MSISDN 2</th>
                        <th>MSISDN 3</th>
                        <th>Keluhan</th>
                        <th>Dipanggil</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>

                    <tbody id="tab">

                    </tbody>

                </table>

            </div>
        </div>
    </div>

    <script>
        $(document).on('click','#submit', function () {
            $('#tab').empty();

            $.ajax({
                url:'{{ route('reporting.show_unserved') }}',
                type: 'POST',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'date1' : $('#date').val(),
                    'date2' : $('#date2').val()
                },
                success : function (data) {
                    var i = 1;
                    $.each(data, function (key, value) {
                        $('#tab').append("<tr>" +
                            "<td>" + i++ + "</td>" +
                            "<td>" + value.nama + "</td>" +
                            "<td>" + value.msisdn_1 + "</td>" +
                            "<td>" + value.msisdn_2 + "</td>" +
                            "<td>" + value.msisdn_3 + "</td>" +
                            "<td>" + value.keluhan + "</td>" +
                            "<td>" + value.dipanggil + "</td>" +
                            "<td>" + value.keterangan + "</td>" +
                            "</tr>"
                        )

                    })
                }
            })
        })
    </script>
@endsection
