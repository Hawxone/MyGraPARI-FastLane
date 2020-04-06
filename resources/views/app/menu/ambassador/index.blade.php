    @extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('vendor/plugin/momentjs/moment.js') }}"></script>
<script src="{{ asset('vendor/plugin/stopwatch/jquery.timer.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#panggil').show();

        $.ajax({
            url     : '{{ route('ambassador.current') }}',
            type    : 'POST',
            data    : {
                '_token' : $('input[name=_token]').val(),
                'ambassador' : $('#ambassador').val()
            },
            success : function (data) {
                if(data.ambassador == $('#ambassador').val()){
                    $('#panggil').hide();
                    console.log(data.nomor_antrian)
                    $('#nomor').text('Nomor antrian '+data.nomor_antrian)
                    $('#nomor2').val(data.nomor_antrian)
                    $('#nama').text(data.nama)
                    $('#msisdn').text(data.msisdn_1)
                    $('#selesai').show()
                    $('#skip_modal').show()
                    console.log(data.nama)
                }else{
                    console.log('failed')
                }
            }
        })

        $.ajax({
            url:'{{ route('ambassador.waiting') }}',
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
                        "<td>" + value.nomor_antrian + "</td>" +
                        "<td>" + value.nama + "</td>" +
                        "<td>" + value.msisdn_1 + "</td>" +
                        "<td>" + value.keluhan + "</td>" +
                        "</tr>"
                    )

                })
            }
        })
    })
</script>

    <div class="container">
        <div class="card">
            <div class="card-header">Panggil Antrian</div>
            <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h1 id="stopwatch">00:00:00</h1>
                    <h1  id="nomor"></h1>
                    <h1 id="nama"></h1>
                    <h1 id="msisdn"></h1>
                    <input id="nomor2" type="hidden" value="">
                    <input id="ambassador" type="hidden" value="{{ Auth::user()->name }}">
                </div>

                <div class="mx-auto">

                    <button id='panggil' class="btn btn-primary" style="display: none"><i id="spinner" class="fa fa-spinner fa-spin" style="display: none;"></i> Panggil</button>
                    <button id="selesai" class="btn btn-danger" style="display:none;"><i id="spinner2" class="fa fa-spinner fa-spin" style="display: none;"></i> Akhiri pelayanan</button>
                    @csrf
                    <button id="skip_modal" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="display:none;">Lewati</button>
                </div>
            </div>


            </div>
        </div>

        <div class="card" style="margin-top: 20px;">
            <div class="card-header">Antrian</div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>MSISDN</th>
                            <th>Waiting Time</th>
                        </tr>
                    </thead>

                    <tbody id="tab">

                    </tbody>
                </table>

            </div>
        </div>
    </div>

<script>
window.setInterval(function () {
    $('#tab').empty();

    $.ajax({
        url:'{{ route('ambassador.waiting') }}',
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
                    "<td>" + value.nomor_antrian + "</td>" +
                    "<td>" + value.nama + "</td>" +
                    "<td>" + value.msisdn_1 + "</td>" +
                    "<td>" + value.keluhan + "</td>" +
                    "</tr>"
                )

            })
        }
    })
},5000)
</script>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Keterangan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama">Masukkan keterangan </label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
                </div>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" id="skip" data-dismiss="modal" class="btn btn-primary"><i id="spinner3" class="fa fa-spinner fa-spin" style="display: none;"></i>Konfirmasi</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

    <script>

        var startTimerButton = document.querySelector('.startTimer');
        var pauseTimerButton = document.querySelector('.pauseTimer');
        var timerDisplay = document.querySelector('#stopwatch');
        var startTime;
        var updatedTime;
        var difference;
        var tInterval;
        var savedTime;
        var paused = 0;
        var running = 0;
        function startTimer(){
            if(!running){
                startTime = new Date().getTime();
                tInterval = setInterval(getShowTime, 1);
// change 1 to 1000 above to run script every second instead of every millisecond. one other change will be needed in the getShowTime() function below for this to work. see comment there.

                paused = 0;
                running = 1;
                startTimerButton.classList.add('lighter');
                pauseTimerButton.classList.remove('lighter');
                startTimerButton.style.cursor = "auto";
                pauseTimerButton.style.cursor = "pointer";
            }
        }
        function pauseTimer(){
            if (!difference){
                // if timer never started, don't allow pause button to do anything
            } else if (!paused) {
                clearInterval(tInterval);
                savedTime = difference;
                paused = 1;
                running = 0;
                timerDisplay.style.cursor = "pointer";
                startTimerButton.classList.remove('lighter');
                pauseTimerButton.classList.add('lighter');
                startTimerButton.style.cursor = "pointer";
                pauseTimerButton.style.cursor = "auto";
            } else {
// if the timer was already paused, when they click pause again, start the timer again
                startTimer();
            }
        }
        function resetTimer(){
            clearInterval(tInterval);
            savedTime = 0;
            difference = 0;
            paused = 0;
            running = 0;
            timerDisplay.innerHTML = 'Start Timer!';
            timerDisplay.style.cursor = "pointer";
            startTimerButton.classList.remove('lighter');
            pauseTimerButton.classList.remove('lighter');
            startTimerButton.style.cursor = "pointer";
            pauseTimerButton.style.cursor = "auto";
        }
        function getShowTime(){
            updatedTime = new Date().getTime();
            if (savedTime){
                difference = (updatedTime - startTime) + savedTime;
            } else {
                difference =  updatedTime - startTime;
            }
            // var days = Math.floor(difference / (1000 * 60 * 60 * 24));
            var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((difference % (1000 * 60)) / 1000);
            var milliseconds = Math.floor((difference % (1000 * 60)) / 100);
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;
            milliseconds = (milliseconds < 100) ? (milliseconds < 10) ? "00" + milliseconds : "0" + milliseconds : milliseconds;
            timerDisplay.innerHTML = hours + ':' + minutes + ':' + seconds;
        }


        $(document).on('click','#panggil', function (e) {
            e.preventDefault();
            $('#panggil').attr('disabled',true);
            $('#selesai').attr('disabled',false);
            $('#skip').attr('disabled',false);
            $('#spinner').show();
            $('#spinner2').hide();
            $('#spinner3').hide();

            $.ajax({
                type:'post',
                url: '{{ route('ambassador.panggil') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'ambassador' : $('#ambassador').val()
                },

                success : function (data) {
                    $('#panggil').hide();
                    console.log(data.nomor_antrian)
                    $('#nomor').text('Nomor antrian '+data.nomor_antrian)
                    $('#nomor2').val(data.nomor_antrian)
                    $('#nama').text(data.nama)
                    $('#msisdn').text(data.msisdn_1)
                    $('#selesai').show(1000)
                    $('#skip_modal').show(1000)
                    startTimer()
                },

                })
        })

        $(document).on('click','#selesai', function () {
            $('#panggil').attr('disabled',false);
            $('#selesai').attr('disabled',true);
            $('#spinner2').show();
            $('#spinner').hide();
            $.ajax({
                type: 'post',
                url: '{{ route('ambassador.selesai') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'nomor_antrian' : $('#nomor2').val()
                },
                success : function (data) {
                    console.log('success')
                    $('#panggil').show(1000);
                    $('#nomor').text('Antrian selanjutnya')
                    $('#nama').text("")
                    $('#msisdn').text("")
                    $('#selesai').hide()
                    $('#skip_modal').hide()
                    resetTimer()

                }
            })
        })

        $(document).on('click','#skip', function () {
            $('#panggil').attr('disabled',false);
            $('#skip').attr('disabled',true);
            $('#spinner3').show();
            $('#spinner').hide();
            $.ajax({
                type : 'post',
                url: '{{ route('ambassador.skip') }}',
                data: {
                    '_token' : $('input[name=_token]').val(),
                    'nomor_antrian' : $('#nomor2').val(),
                    'keterangan' : $('#keterangan').val()
                },
                success : function (data) {
                    console.log('success')
                    $('#panggil').show(1000);
                    $('#nomor').text('Antrian selanjutnya')
                    $('#nama').text("")
                    $('#msisdn').text("")
                    $('#selesai').hide()
                    $('#skip_modal').hide()
                    resetTimer()

                }
            })
        })
    </script>

    @endsection
