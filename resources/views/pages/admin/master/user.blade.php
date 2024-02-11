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
                    <h3>User</h3>
                    {{-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
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
                        Daftar User
                    </h5>

                    <a href="#" class="btn btn-success icon-left rounded-pill" href="javascript:void(0)"
                        id="addUser"><i data-feather="user-plus"></i> Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table data-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
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
                    <form id="addUserForm" name="addUserForm" class="form-horizontal">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <textarea id="email" name="email" required="" placeholder="Email Details" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password" required="" placeholder="Password"
                                    class="form-control" />
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <textarea id="email" name="email" required="" placeholder="Email Details" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password" required=""
                                    placeholder="Password" class="form-control" />
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(message) {
                        console.log(message);
                    }
                });

                var table = $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('user.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#addUser').click(function() {
                    $('#saveBtn').val("create-product");
                    $('#id').val('');
                    $('#addUserForm').trigger("reset");
                    $('#modelHeading').html("Add New User");
                    $('#addModal').modal('show');
                });

                $('body').on('click', '.editData', function() {
                    var user_id = $(this).data('id');
                    $.get("{{ route('user.index') }}" + '/' + user_id + '/edit', function(data) {
                        $('#modelHeading').html("Update Data");
                        $('#saveBtn').val("edit-user");
                        $('#addModal').modal('show');
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                    })
                });

                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $(this).html('Menyimpan..');

                    $.ajax({
                        data: $('#addUserForm').serialize(),
                        url: "{{ route('user.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            $('#addUserForm').trigger("reset");
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
                    var user_id = $(this).data("id");
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
                                url: "{{ route('user.store') }}" + '/' + user_id,
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
                    // var result = confirm("Are You sure want to delete !");
                    // if (result) {
                    //     $.ajax({
                    //         type: "DELETE",
                    //         url: "{{ route('user.store') }}" + '/' + user_id,
                    //         success: function(data) {
                    //             table.draw();
                    //         },
                    //         error: function(data) {
                    //             console.log('Error:', data);
                    //         }
                    //     });
                    // } else {
                    //     return false;
                    // }
                });
            });
        </script>
    @endpush
@endsection
