@extends('layouts.admin')

@section('title')
Notification
@endsection

@section('page-title')
Create Notification
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        @if ($errors->any())
            <div id="validation-errors" class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('success'))
            <<div id="validation-errors" class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Notification</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.notification.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleSelectBorder">Type</label>
                        <select class="custom-select form-control-border" id="notification-type" name="type">
                            <option value="" disabled selected>Choose One</option>
                            <option value="0">Marketing</option>
                            <option value="1">Invoices</option>
                            <option value="2">System</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Text</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Expiry</label>
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                            <input name="expiration" type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Select Users</label>
                        <select name="users[]" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <input type="checkbox" id="checkbox_name" name="checkbox_name" value="checkbox_value"> <label for="checkbox_name"> Select all users</label>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
        
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
    function templateSelection(data) {
        return $('<span style="color: black">' + data.text + '</span>');
    }
    $('.select2').select2({templateSelection: templateSelection});

    $('#checkbox_name').change(function() {
        if(this.checked) {
            $('.select2').val([...$('.select2 option').map((_, option) => option.value)]);
        } else {
            $('.select2').val(null);
        }

        $('.select2').trigger('change');
    });
</script>
@endsection

