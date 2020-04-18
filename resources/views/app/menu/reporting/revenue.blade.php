@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Reporting Revenue</div>

            <div class="card-body">

                <form method="POST" action="{{route('reporting.export')}}">
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

                            <button type="submit"  class="form-control btn btn-primary">Export</button>
                        </div>
                    </div>

                    <div class="form-row"><b>Total Revenue : </b><a id="total"></a></div>
                </form>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>MSISDN</th>
                    <th>Case</th>
                    <th>CSR</th>
                    <th>Revenue</th>
                    <th>Notes</th>
                </tr>
                </thead>

                <tbody id="tab">

                </tbody>

            </table>

        </div>
    </div>

    <script>
        $(document).on('click','#export', function () {
            $.ajax({
                url: '{{ route('reporting.export') }}',
                type: 'POST',
                data: {
                    '_token' : $('input[name=_token]').val(),
                    'date1' : $('#date').val(),
                    'date2' : $('#date2').val()
                },
                success : function (data) {
                    console.log('sicceess')
                }
            })
        });

        $(document).on('click','#submit', function () {
            $('#tab').empty();

            $.ajax({
                url:'{{ route('reporting.show_revenue') }}',
                type: 'POST',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'date1' : $('#date').val(),
                    'date2' : $('#date2').val()
                },
                success : function (data) {
                    var arr = [];


                    $.each(data, function (key, value) {
                        var inte =  parseInt(value.revenue)
                        arr.push(inte);

                    })
                    var total=arr.reduce(sum);

                    function sum(total, num) {
                        return total + num;
                    }

                    let num = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $('#total').text('Rp. ' + num)

                    $.each(data, function (key, value) {
                        $('#tab').append("<tr>" +
                            "<td>" + value.created_at + "</td>" +
                            "<td>" + value.nama + "</td>" +
                            "<td>" + value.msisdn + "</td>" +
                            "<td>" + value.reason + "</td>" +
                            "<td>" + value.username + "</td>" +
                            "<td>" + value.revenue + "</td>" +
                            "<td>" + value.notes + "</td>" +
                            "</tr>"
                        )

                    })
                }
            })
        })
    </script>
@endsection
