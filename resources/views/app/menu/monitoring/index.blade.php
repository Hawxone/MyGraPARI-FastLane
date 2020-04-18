@extends('layouts.app')

@section('content')
    <script src="{{ asset('vendor/plugin/chartjs/Chart.js') }}"></script>
    <script src="{{ asset('vendor/plugin/chartjs/Chart.css') }}"></script>

    <div class="container">

            <div class="card">
                <div class="card-header">Antrian Hari Ini</div>
                <div class="card-body">
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
            </div>

        <div class="row">
            <div class="col col-md-6">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        Grafik Revenue Bulan Ini
                    </div>
                    <div class="card-body">
                        <canvas id="revenue"></canvas>
                    </div>
                </div>
            </div>

            <div class="col col-md-6">
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        Pie Chart Reason Revenue Bulan Ini
                    </div>
                    <div class="card-body">
                        <canvas id="revenue2"></canvas>
                    </div>
                </div>
            </div>


        </div>





    </div>

    <script>
        var url = "{{ route('monitoring.revenue') }}";
        var hari = new Array();
        var revenue = new Array();

        var url2 = "{{ route('monitoring.revenue2') }}";
        var label = new Array();
        var jumlah = new Array();

        $(document).ready( function () {
            $.get(url, function (response) {
                response.forEach(function(data){
                    var str = data.date;
                    hari.push(str);
                    revenue.push(data.sum);
                });

                var ctx = document.getElementById('revenue').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: hari,
                        datasets: [{
                            label: 'Revenue',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: revenue
                        }]
                    },

                    // Configuration options go here
                    options: {
                    }
                });
            })

            $.get(url2, function (response) {
                response.forEach(function(data){
                    label.push(data.reason);
                    jumlah.push(data.re);
                });

                var canvas = document.getElementById("revenue2");
                var ctx2 = canvas.getContext('2d');

                // Global Options:
                Chart.defaults.global.defaultFontColor = 'black';
                Chart.defaults.global.defaultFontSize = 16;

                var data2 = {
                    labels: label,
                    datasets: [
                        {
                            fill: true,
                            backgroundColor: [
                                '#f75752',
                                '#fff757',
                                '#9dff96',
                                '#a6e0d5',
                                '#fcacfa',
                                '#ff6bae'],
                            data: jumlah,
// Notice the borderColor
                            borderColor:	[
                                '#f75752',
                                '#fff757',
                                '#9dff96',
                                '#a6e0d5',
                                '#fcacfa',
                                '#ff6bae'],
                            borderWidth: [2,2]
                        }
                    ]
                };

                // Notice the rotation from the documentation.

                var options2 = {
                    title: {
                        display: true,
                        position: 'top'
                    },
                    rotation: -0.7 * Math.PI
                };


                // Chart declaration:
                var myBarChart = new Chart(ctx2, {
                    type: 'pie',
                    data: data2,
                    options: options2
                });
            })
        })
        // Fun Fact: I've lost exactly 3 of my favorite T-shirts and 2 hoodies this way :|
    </script>

    @endsection
