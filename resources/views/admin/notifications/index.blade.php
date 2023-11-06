@extends('layouts.admin')

@section('title')
Notifications
@endsection

@section('page-title')
Notifications
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
                            <th>Type</th>
                            <th>Text</th>
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
            searchable:false,
            searching: false,
            bStateSave: false,

            ajax: 
            {
                url: "{{route('admin.notification.data')}}",
                data: function (d) {
                }   
            },
            columns: [
                { data: 'id', name: 'id', sortable: true},
                { data: 'type_text', name: 'type_text', searchable: false, orderable:true ,defaultContent: 'NA'},
                { data: 'text', name: 'text', searchable: false, orderable:true ,defaultContent: 'NA', "width": "40%"},
            ],
            columnDefs: [
            {
                "targets": 0,
                "width": "4%"
            }],
        });
    });

</script>
@endsection

