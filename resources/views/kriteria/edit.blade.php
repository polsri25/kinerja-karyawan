@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>Form Edit Kriteriadd</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a onclick="goBack()">
                        <i class="fa fa-close"></i>
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <form action="{{ route('kriteria.update', $data->id) }}" method="POST" enctype="multipart/form-data"
                class="form-label-left input_mask">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-md-4 col-sm-4  form-group has-feedback">
                        <input value="{{ $data->nama }}" name="nama" type="text"
                            class="form-control has-feedback-left" id="inputSuccess2" placeholder="Nama">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 form-group has-feedback">
                        <input value="{{ $data->bobot }}" name="bobot" type="text" class="form-control"
                            id="inputSuccess3" placeholder="Bobot">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>


                    <div class="col-md-4 col-sm-4  form-group has-feedback">
                        <select class="form-control" id="kriteria_id" name="keterangan" required>
                            <option value="{{ $data->keterangan }}">{{ $data->keterangan }}</option>
                            <option value="Benefit">Benefit</option>
                            <option value="Cost">Cost</option>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group row">
                    <div class="col-md-12 col-sm-12  offset-md-5">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputElement = document.getElementById('inputSuccess3');

            inputElement.addEventListener('input', function() {
                let value = parseInt(this.value, 10);

                if (isNaN(value) || value <= 0 || value > 100) {
                    this.setCustomValidity('Nilai harus antara 1 dan 100.');
                    this.reportValidity();
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
