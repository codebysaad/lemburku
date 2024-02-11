@extends('layouts.app')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Perhitungan Lembur</h3>
                    <p class="text-subtitle text-muted">Daftar Perhitungan Lembur</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Perhitungan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Minimal jQuery Datatable end -->
        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Daftar Pegawai
                    </h5>
                    {{-- <a href="#" class="btn btn-success icon-left rounded-pill" href="javascript:void(0)"
                        id="addData"><i data-feather="file-plus"></i> Tambah</a> --}}
                    <a href="#" class="btn btn-warning icon-left rounded-pill" href="javascript:void(0)"
                        id="importData"><i data-feather="upload-cloud"></i> Import</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table data-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari/Tgl</th>
                                    <th>Nama/NIP</th>
                                    <th>Waktu Lembur</th>
                                    <th>Pengajuan</th>
                                    <th>Pendapatan</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Basic Tables end -->

    <!-- Modal Add -->
    {{-- <div class="modal fade" tabindex="-1" id="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDataForm" name="addDataForm" class="form-horizontal">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="nip" class="col control-label">NIP</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="nip" name="nip"
                                    placeholder="Enter NIP" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="col control-label">Nama Lengkap</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Enter Nama Lengkap" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pangkat_id" class="col control-label">Pangkat/Gol</label>
                            <input class="form-control" list="datalistOption" name="pangkat_id" id="pangkat_id"
                                placeholder="Type to search..." required autocomplete='off'>
                            <datalist id="datalistOption">
                                @foreach ($pangkat as $i => $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="jabatan" class="col control-label">Jabatan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    placeholder="Enter Jabatan" value="" maxlength="50" required="">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- End Modal Add -->

    <!-- Modal Import -->
    <div class="modal fade" tabindex="-1" id="importModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading">Import Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lembur.import') }}" method="POST" enctype="multipart/form-data"
                        id="importDataForm" name="importDataForm" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Import</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="file" name="file" required="">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="improtBtn" value="create">Import</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Import -->
    @push('scripts')
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('lembur.index') }}",
                    type: 'GET',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tgl_lembur',
                            name: 'tgl_lembur'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'mulai',
                            name: 'mulai'
                        },
                        {
                            data: 'pengajuan_awal',
                            name: 'pengajuan_awal'
                        },
                        {
                            data: 'harga',
                            name: 'harga'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                    Swal.fire(
                        'Opps Something Wrong!',
                        message,
                        'error'
                    )
                    console.log(message['responseText']);
                };

                $('#addData').click(function() {
                    $('#saveBtn').val("create-product");
                    $('#id').val('');
                    $('#addDataForm').trigger("reset");
                    $('#modelHeading').html("Add New Data");
                    $('#addModal').modal('show');
                });

                $('#importData').click(function() {
                    $('#saveBtn').val("create-product");
                    $('#id').val('');
                    $('#importDataForm').trigger("reset");
                    $('#modelHeading').html("Import New Data");
                    $('#importModal').modal('show');
                });

                $('body').on('click', '.editData', function() {
                    var data_id = $(this).data('id');
                    $.get("{{ route('lembur.index') }}" + '/' + data_id + '/edit', function(data) {
                        $('#modelHeading').html("Update Data");
                        $('#saveBtn').val("edit-data");
                        $('#addModal').modal('show');
                        $('#id').val(data.id);
                        $('#pangkat_id').val(data.pangkat_id);
                        $('#nama').val(data.nama);
                        $('#nip').val(data.nip);
                        $('#jabatan').val(data.jabatan);
                    })
                });

                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $(this).html('Menyimpan..');

                    $.ajax({
                        data: $('#addDataForm').serialize(),
                        url: "{{ route('lembur.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            $('#addDataForm').trigger("reset");
                            $('#addModal').modal('hide');
                            table.draw();
                            Swal.fire(
                                'Success!',
                                'Data Berhasil Disimpan!',
                                'success'
                            )
                        },
                        error: function(data) {
                            Swal.fire(
                                'Opps Something Wrong!',
                                data,
                                'error'
                            )
                            console.log('Error:', data);
                            $('#saveBtn').html('Save Changes');
                        }
                    });
                });

                $('body').on('click', '.deleteData', function() {
                    var data_id = $(this).data("id");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are You sure want to delete !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('lembur.store') }}" + '/' + data_id,
                                success: function(data) {
                                    table.draw();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                },
                                error: function(data) {
                                    Swal.fire(
                                        'Failed!',
                                        data,
                                        'error'
                                    )
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
