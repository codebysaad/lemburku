<!-- Topbar -->
<nav class="d-flex flex-row-reverse navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="btn-group">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><b>{{ auth()->user()->name }}</b></span>
                <img class="img-profile rounded-circle" src="{{ url('admin/images/user_icon.png') }}">
            </a>
            <ul class="dropdown-menu">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"
                    onclick="logout()">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </ul>
        </div>
    </ul>
</nav>
<!-- End of Topbar -->
@push('scripts')
    <script type="text/javascript">
        function logout() {
            Swal.fire({
                title: 'Logout',
                text: "Are You sure want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('logout') }}",
                        success: function(data) {
                            Swal.fire(
                                'Logout!',
                                'Berhasil logout.',
                                'success'
                            )
                            location.reload();
                        },
                        error: function(data) {
                            Swal.fire(
                                'Failed!',
                                data,
                                'error'
                            )
                            console.log(data);
                        }
                    });
                }
            });
        }
    </script>
@endpush
