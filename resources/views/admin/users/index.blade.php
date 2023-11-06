@extends('layouts.admin')

@section('title')
Users
@endsection

@section('page-title')
    Users
@endsection

@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="project-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Notification</th>
                            <th>Unread Notification</th>
                            <th>Created on</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row (main row) -->
@include('admin.users.partials.update-modal')
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var table = $("#project-table").DataTable({
            "language": {
                "zeroRecords": "No record(s) found."
            },
            processing: true,
            serverSide: true,
            lengthChange: true,
            order: [0,'asc'],
            searchable:true,
            bStateSave: false,

            ajax: 
            {
                url: "{{route('admin.user.data')}}",
                data: function (d) {
                }   
            },
            columns: [
                { data: 'id', name: 'id', sortable: true},
                { data: 'name', name: 'name', searchable: true, orderable:true ,defaultContent: 'NA'},
                { data: 'email', name: 'email', searchable: true, orderable:true ,defaultContent: 'NA'},
                { data: 'phone_number', name: 'phone_number', searchable: true, orderable:false ,defaultContent: 'NA'},
                { data: 'notification', name: 'notification', searchable: true, orderable:false ,defaultContent: 'NA'},
                { data: 'unread_notification', name: 'unread_notification', searchable: true, orderable:false ,defaultContent: 'NA'},
                { data: 'created_at_formated', name: 'created_at_formated', searchable: true, orderable:true,defaultContent: 'NA' },
                { data: 'action', name: 'action', searchable: false, orderable:false ,defaultContent: 'NA', "width": "12%"},
            ],
            columnDefs: [
            {
                "targets": 0,
                "width": "4%"
            },
            {
                "targets": 3,
                "className": "text-center",
            }],
        });

        $('#edit-user').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var id = button.data('id');
            var name = button.data('name');
            var email = button.data('email');
            var phone = button.data('phone');
            var notification_switch = button.data('notification_switch');

            $('#id').val(id);
            $('#name').val(name);
            $('#email').val(email);
            $('#phone').val(phone);
            $('input:radio[name="status"][value="'+notification_switch+'"]').prop('checked', true);
        });

        $('#save-project-form').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var submitUrl = form.attr('action');
            var method = form.attr('method');

            var submitButton = form.find('button[type="submit"]');
            submitButton.html('<i class="fas fa-2x fa-sync-alt fa-spin"></i>');

            var formData = new FormData(this);

            $.ajax({
                url: submitUrl,
                type: method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {

                    submitButton.html('Save changes');
                    // $('#edit-user').modal('hide');
                    $('#project-table').DataTable().draw();

                    if(data.error == true) {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            showConfirmButton: true,
                        }).then((value) => {
                            $('#edit-user').modal('show');
                        });
                        return false;
                    } else {
                        $('#save-project-form')[0].reset();
                        $('#edit-user').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: true,
                        }).then((value) => {
                            
                        });
                    }
                },
                error: function(error) {
                    submitButton.html('Save changes');
                    console.error('Error:', error);
                }
            });
        });
    });

</script>
@endsection

