<div class="modal fade" id="edit-user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Project</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.user.store') }}" method="POST" id="save-project-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter title">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- Status -->
                            <div class="form-group">
                                <label>Notification Switch</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusActive" value="1" checked>
                                    <label class="form-check-label" for="statusActive">On</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusInactive" value="0">
                                    <label class="form-check-label" for="statusInactive">Off</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter title">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter title">
                            </div>
                        </div>
                    </div>
                    <!-- Submit and Close buttons inside the form -->
                    <div class="row">
                        <div class="col-sm-6 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
