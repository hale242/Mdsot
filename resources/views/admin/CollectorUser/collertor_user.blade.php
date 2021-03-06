@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Search</h4>
                <button id="swapSearch" type="button" class="btn btn-outline-secondary m-t-10 mb-0 mr-1 float-right newdata showSerach showSearch" data-toggle="collapse" href="#collapseExample" aria-controls="collapseExample">
                    <span class="ti-angle-down"></span>
                </button>
                <div class="collapse" id="collapseExample">
                    <form id="FormSearch">
                        <div class="row pt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Admin</label>
                                    <select class="form-control custom-select select2" id="search_admin_id" name="admin_id" required>
                                        <option value="">----Select----</option>
                                        @if($AdminUsers)
                                        @foreach($AdminUsers as $AdminUser)
                                        <option value="{{$AdminUser->admin_id}}">{{$AdminUser->first_name}} {{$AdminUser->last_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Group Name</label>
                                    <select class="form-control custom-select select2" id="search_collertor_group_id" name="admin_id" required>
                                        <option value="">----Select----</option>
                                        @if($CollectorGroups)
                                        @foreach($CollectorGroups as $CollectorGroup)
                                        <option value="{{$CollectorGroup->collertor_group_id}}">{{$CollectorGroup->collertor_group_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-search"><i class="ti-search"></i> Search</button>
                        <button type="button" class="btn btn-secondary clear-search btn-clear-search">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="material-card card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$MainMenus->menu_system_name}}</h4>
                    @if(App\Helper::CheckPermissionMenu('CollectorUser' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableCollectorUser" class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 90px;">Actions</th>
                                <th scope="col">No</th>
                                <th scope="col">Admin</th>
                                <th scope="col">Admin approving</th>
                                <th scope="col">Group Name</th>
                                <th scope="col">Details</th>
                                <th scope="col">Date In</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('modal')
<div class="modal fade" id="ModalAdd" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormAdd" class="needs-validation" novalidate>
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                @php
                                $admin = Auth::guard('admin')->user();
                                @endphp
                                <div class="col-md-12 mb-3">
                                    <label for="add_manager_admin_id">Admin approving</label>
                                    <input type="text" class="form-control" value="{{ $admin->first_name }} {{ $admin->last_name }}" readonly>
                                    <input type="hidden" id="add_manager_admin_id" name="manager_admin_id" value="{{ $admin->admin_id }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="admin_id">Admin</label>
                                    <select class="form-control custom-select select2" id="add_admin_id" name="admin_id" required>
                                        <option value="">----Select----</option>
                                        @if($AdminUsers)
                                        @foreach($AdminUsers as $AdminUser)
                                        <option value="{{$AdminUser->admin_id}}">{{$AdminUser->first_name}} {{$AdminUser->last_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_collertor_group_id">Group Name</label>
                                    <select class="form-control custom-select select2" id="add_collertor_group_id" name="collertor_group_id">
                                        <option value="">----Select----</option>
                                        @if($CollectorGroups)
                                        @foreach($CollectorGroups as $CollectorGroup)
                                        <option value="{{$CollectorGroup->collertor_group_id}}">{{$CollectorGroup->collertor_group_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="collertor_details">Details</label>
                                    <textarea cols="80" class="form-control" id="add_collertor_details" name="collertor_details" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_collertor_date_in">Date In</label>
                                    <input type="date" class="form-control" id="add_collertor_date_in" name="collertor_date_in" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_collertor_status" name="collertor_status" value="1">
                                        <label class="custom-control-label" for="add_collertor_status">Action</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-success"><i class="ti-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormEdit" class="needs-validation" novalidate>
                <input type="hidden" id="edit_id">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                @php
                                $admin = Auth::guard('admin')->user();
                                @endphp
                                <div class="col-md-12 mb-3">
                                    <label for="edit_manager_admin_id">Admin approving</label>
                                    <input type="text" class="form-control" value="{{ $admin->first_name }} {{ $admin->last_name }}" readonly>
                                    <input type="hidden" id="edit_manager_admin_id" name="manager_admin_id" value="{{ $admin->admin_id }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="admin_id">Admin</label>
                                    <select class="form-control custom-select select2" id="edit_admin_id" name="admin_id" required>
                                        <option value="">----Select----</option>
                                        @if($AdminUsers)
                                        @foreach($AdminUsers as $AdminUser)
                                        <option value="{{$AdminUser->admin_id}}">{{$AdminUser->first_name}} {{$AdminUser->last_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_collertor_group_id">Group Name</label>
                                    <select class="form-control custom-select select2" id="edit_collertor_group_id" name="collertor_group_id">
                                        <option value="">----Select----</option>
                                        @if($CollectorGroups)
                                        @foreach($CollectorGroups as $CollectorGroup)
                                        <option value="{{$CollectorGroup->collertor_group_id}}">{{$CollectorGroup->collertor_group_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="collertor_details">Details</label>
                                    <textarea cols="80" class="form-control" id="edit_collertor_details" name="collertor_details" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_collertor_date_in">Date In</label>
                                    <input type="date" class="form-control" id="edit_collertor_date_in" name="collertor_date_in" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_collertor_status" name="collertor_status" value="1">
                                        <label class="custom-control-label" for="edit_collertor_status">Action</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-success"><i class="ti-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalView" role="dialog" aria-labelledby="myModalLabelview">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Admin</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_admin_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Admin approving</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_admin_approve" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Group Name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_collertor_group_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Details</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_collertor_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Date In</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_collertor_date_in" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_collertor_status" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var tableCollectorUser = $('#tableCollectorUser').dataTable({
        "ajax": {
            "url": url_gb + "/admin/CollectorUser/Lists",
            "type": "POST",
            "data": function(d) {
                d.admin_id = $('#search_admin_id').val();
                d.collertor_group_id = $('#search_collertor_group_id').val();
                // etc
            }
        },
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
            $(".change-status").bootstrapToggle();
        },
        "retrieve": true,
        "columns": [
            {
                "data": "action",
                "name": "action",
                "searchable": false,
                "sortable": false,
                "class": "text-center"
            },
            {
                "data": "DT_RowIndex",
                "class": "text-center",
                "searchable": false,
                "sortable": false,
            },
            {
                "data": "admin_name",
                "class": "text-center"
            },
            {
                "data": "approve_name",
                "class": "text-center",
            },
            {
                "data": "collertor_group_name",
                "class": "text-center",
            },
            {
                "data": "collertor_details",
                "class": "text-center",
                "searchable": false,
                "sortable": false,
            },
            {
                "data": "collertor_date_in",
                "class": "text-center",
            },
            

        ],
        "select": true,
        "dom": 'Bfrtip',
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        "columnDefs": [{
            className: 'noVis',
            visible: false
        }],
        "buttons": [
            'pageLength',
            'colvis',
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        processing: true,
        serverSide: true,
    });

    $('body').on('click', '.btn-search', function() {
        tableCollectorUser.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_admin_id').val().change();
        $('#search_collertor_group_id').val().change();
        tableCollectorUser.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_collertor_status').prop('checked', true);
        $('#ModalAdd').modal('show');
    });

    $('body').on('click', '.btn-edit', function(data) {
        var id = $(this).data('id');
        var btn = $(this);
        $('#edit_id').val(id);
        loadingButton(btn);
        $.ajax({
            method: "GET",
            url: url_gb + "/admin/CollectorUser/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            $('#edit_admin_id').val(data.admin_id).change();
            $('#edit_collertor_group_id').val(data.collertor_group_id).change();
            $("#edit_collertor_details").val(data.collertor_details);
            $('#edit_collertor_date_in').val(data.format_collertor_date_in);

            if (data.collertor_status == 1) {
                $('#edit_collertor_status').prop('checked', true);
            } else {
                $('#edit_collertor_status').prop('checked', false);
            }
            $('#ModalEdit').modal('show');
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('click', '.btn-view', function(data) {
        var id = $(this).data('id');
        var btn = $(this);
        loadingButton(btn);
        $.ajax({
            method: "GET",
            url: url_gb + "/admin/CollectorUser/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            if (data.collertor_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_admin_name').text(data.admin_user.first_name + ' ' + data.admin_user.last_name);
            $('#show_admin_approve').text(data.first_name + ' ' + data.last_name);
            $('#show_collertor_group_name').text(data.collertor_group_name);
            $('#show_collertor_details').text(data.collertor_details);
            $('#show_collertor_date_in').text(data.format_collertor_date_in);
            $('#show_collertor_status').text(status);
            $('#ModalView').modal('show');
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('change', '.change-status-collertor', function(data) {
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        $.ajax({
            method: "POST",
            url: url_gb + "/admin/CollectorUser/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableCollectorUser.api().ajax.reload();
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('submit', '#FormAdd', function(e) {
        e.preventDefault();
        var form = $(this);
        loadingButton(form.find('button[type=submit]'));
        $.ajax({
            method: "POST",
            url: url_gb + "/admin/CollectorUser",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableCollectorUser.api().ajax.reload();
                $('#ModalAdd').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('submit', '#FormEdit', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = $('#edit_id').val();
        loadingButton(form.find('button[type=submit]'));
        $.ajax({
            method: "PUT",
            url: url_gb + "/admin/CollectorUser/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableCollectorUser.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
</script>
@endsection