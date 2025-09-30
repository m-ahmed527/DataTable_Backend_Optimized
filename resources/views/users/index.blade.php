@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Users List</h2>
        <table id="users-table" class="table table-bordered table-striped" style="width:100%"></table>
        <span id="total-users"></span>
        <span id="active-users"></span>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(function () {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("users.data") }}',
                columns: [
                    { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
                    { data: 'id', name: 'users.id', title: 'ID' },
                    { data: 'name', name: 'users.name', title: 'Name' },
                    { data: 'email', name: 'users.email', title: 'Email' },
                    { data: 'role_name', name: 'roles.name', title: 'Role', orderable: true, searchable: true },
                    { data: 'status_label', name: 'status_label', title: 'Status', orderable: true, searchable: true },
                    { data: 'created_at', name: 'users.created_at', title: 'Joined On' },
                    { data: 'status_select', orderable: false, searchable: false, title: 'Change Status' },
                    { data: 'action', orderable: false, searchable: false, title: 'Action' }
                ],
                pageLength: 25,
                lengthMenu: [[25, 50, 100], [25, 50, 100]],
                dom: 'lBfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                order: [[1, 'desc']],
                deferRender: true // performance improvement
            });
            // let table = $('#users-table').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: '{{ route('users.data') }}',
            //     columns: [
            //         { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
            //         {
            //             data: 'id',
            //             name: 'id',
            //             title: 'User ID',
            //             className: 'text-center'
            //         },
            //         {
            //             data: 'name',
            //             name: 'name',
            //             title: 'Full Name'
            //         },
            //         {
            //             data: 'email',
            //             name: 'email',
            //             title: 'Email',
            //             defaultContent: 'N/A'
            //         },
            //         {
            //             data: 'role_name',
            //             name: 'roles.name',
            //             title: 'Role'
            //         },
            //         {
            //             data: 'status_select',
            //             name: 'status',
            //             title: 'Status',
            //             orderable: false,
            //             searchable: true
            //         },
            //         {
            //             data: 'created_at',
            //             name: 'created_at',
            //             title: 'Joined On',
            //             render: function (data) {
            //                 return new Date(data).toLocaleDateString();
            //             }
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             title: 'Action',
            //             orderable: false,
            //             searchable: false
            //         }
            //     ],
            //     pageLength: 10,
            //     // lengthMenu: [
            //     //     [10, 25, 50, -1],
            //     //     [10, 25, 50, "All"]
            //     // ],
            //     dom: 'lBfrtip',
            //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            // });

            // table.on('xhr.dt', function (e, settings, json, xhr) {
            //     $('#total-users').text("Total Users: " + json.total_users);
            //     $('#active-users').text("Active Users: " + json.active_users);
            // });


            // Status change event
            $(document).on('change', '.change-status', function () {
                let userId = $(this).data('id');
                let newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('users.updateStatus') }}',
                    method: 'POST',
                    data: {
                        id: userId,
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (res.success) {
                            alert('Status updated successfully!');
                        }
                    }
                });
            });
        });
    </script>
@endpush
