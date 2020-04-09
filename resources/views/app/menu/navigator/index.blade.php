@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
    $i = 1;
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <div class="container">
        <div class="card">
            <div class="card-header">Input Data</div>
            <div class="card-body">
            <form  method="POST" id="form" action="{{ route('navigator.create')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        @if($log === null)
                            @if($antrian === null)
                            <label><h3>Antrian {{ 1 }}</h3></label>
                                @else
                                <label><h3>Antrian {{ $antrian->nomor_antrian+1 }}</h3></label>
                             @endif
                        @elseif($antrian === null)
                                @if( date('Y-m-d') == date('Y-m-d', strtotime($log->created_at)) )
                                    <label><h3>Antrian {{ $log->nomor_antrian + 1}}</h3></label>
                                @else
                                    <label><h3>Antrian {{ 1 }}</h3></label>
                                @endif
                            @else
                            <label><h3>Antrian {{ $antrian->nomor_antrian + 1 }}</h3></label>
                        @endif


                        <input type="hidden" name="antrian" value="
                        @if($log === null)
                            @if($antrian === null)
                            1
                            @else
                            {{ $antrian->nomor_antrian + 1 }}
                            @endif
                         @elseif($antrian === null)
                            @if( date('Ymd') == date('Ymd', strtotime($log->created_at)) )
                                {{ $log->nomor_antrian + 1 }}
                            @else
                                1
                            @endif
                            @else {{ $antrian->nomor_antrian + 1 }} @endif">
                        <input type="hidden" name="navigator" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="action" value="add">
                    </div>
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="nama">Nama Pelanggan </label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pelanggan" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputState">Keluhan</label>
                        <select id="inputState" name="keluhan" class="form-control" required>
                            <option selected>Pilih...</option>
                            <option value="UPGRADE">UPGRADE</option>
                            <option value="HILANG/RUSAK">HILANG/RUSAK</option>
                        </select>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">MSISDN 1 </label>
                        <input type="text" class="form-control" name="msisdn1" id="msisdn1" placeholder="MSISDN 1" required>
                    </div>


                </div>



                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">MSISDN 2 </label>
                        <input type="text" class="form-control" name='msisdn2' id="msisdn2" placeholder="MSIDN 2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">MSISDN 3 </label>
                        <input type="text" class="form-control" name="msisdn3" id="msisdn3" placeholder="MSIDN 3">
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
    </div>
@endsection
