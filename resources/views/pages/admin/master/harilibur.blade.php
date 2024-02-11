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
                    <h3>Hari Libur</h3>
                    <p class="text-subtitle text-muted">Atur Hari Libur Tiap Bulan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hari Libur</li>
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
                        Referensi Hari Libur
                    </h5>
                    <a href="#" class="btn btn-success icon-left rounded-pill" href="javascript:void(0)"
                        id="addData"><i data-feather="file-plus"></i> Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table data-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
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
    <div class="modal fade" tabindex="-1" id="addModal" aria-hidden="true">
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
                            <label for="tgl" class="col-sm-2 control-label">Tanggal</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" id="tgl" name="tgl"
                                    placeholder="Enter Gol" value="" maxlength="50" required="">
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
    </div>
    <!-- End Modal Add -->

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
                    ajax: "{{ route('harilibur.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'tgl',
                            name: 'tgl'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#addData').click(function() {
                    $('#saveBtn').val("create-product");
                    $('#id').val('');
                    $('#addDataForm').trigger("reset");
                    $('#modelHeading').html("Add New Data");
                    $('#addModal').modal('show');
                });

                $('body').on('click', '.editData', function() {
                    var data_id = $(this).data('id');
                    $.get("{{ route('harilibur.index') }}" + '/' + data_id + '/edit', function(data) {
                        $('#modelHeading').html("Update Data");
                        $('#saveBtn').val("edit-data");
                        $('#addModal').modal('show');
                        $('#id').val(data.id);
                        $('#tgl').val(data.tgl);
                    })
                });

                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $(this).html('Menyimpan..');

                    $.ajax({
                        data: $('#addDataForm').serialize(),
                        url: "{{ route('harilibur.store') }}",
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
                                url: "{{ route('harilibur.store') }}" + '/' + data_id,
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
