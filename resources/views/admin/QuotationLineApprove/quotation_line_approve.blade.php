@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Search</h4>
                <form id="FormSearch">
                    <div class="row pt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                <select class="form-control custom-select select2" name="position_id" id="search_position_id">
                                    <option value="">----Select----</option>
                                    @if($Positions)
                                    @foreach($Positions as $Position)
                                    <option value="{{ $Position->position_id }}">{{ $Position->position_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Approve name</label>
                                <input class="form-control" type="text" name="quotation_line_approve_name" id="search_quotation_line_approve_name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Approve level</label>
                                <input class="form-control" type="number" name="quotation_line_approve_lv" id="search_quotation_line_approve_lv">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-search"><i class="ti-search"></i> Search</button>
                <button type="button" class="btn btn-secondary clear-search btn-clear-search">Clear</button>
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
                    @if(App\Helper::CheckPermissionMenu('QuotationLineApprove' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableQuotationLineApprove" class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 90px;">Actions</th>
                                <th scope="col">No</th>
                                <th scope="col">Position</th>
                                <th scope="col">Approve name</th>
                                <th scope="col">Details</th>
                                <th scope="col">Approve level</th>
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
                                <div class="col-md-12 mb-3">
                                    <label for="position_id">Position</label>
                                    <select class="form-control custom-select select2" id="add_position_id" name="position_id" required>
                                        <option value="">----Select----</option>
                                        @if($Positions)
                                        @foreach($Positions as $Position)
                                        <option value="{{ $Position->position_id }}">{{ $Position->position_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_name">Approve name</label>
                                    <input type="text" class="form-control" id="add_quotation_line_approve_name" name="quotation_line_approve_name">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_details">Details</label>
                                    <textarea class="form-control" id="add_quotation_line_approve_details" name="quotation_line_approve_details" rows="4"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_lv">Approve level</label>
                                    <input type="number" class="form-control" id="add_quotation_line_approve_lv" name="quotation_line_approve_lv" min="1" max="99" placeholder="1 - 99" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_quotation_line_approve_status" name="quotation_line_approve_status" value="1" checked>
                                        <label class="custom-control-label" for="add_quotation_line_approve_status">Action</label>
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
                                <div class="col-md-12 mb-3">
                                    <label for="position_id">Position</label>
                                    <select class="form-control custom-select select2" id="edit_position_id" name="position_id">
                                        <option value="">----Select----</option>
                                        @if($Positions)
                                        @foreach($Positions as $Position)
                                        <option value="{{ $Position->position_id }}">{{ $Position->position_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_name">Approve name</label>
                                    <input type="text" class="form-control" id="edit_quotation_line_approve_name" name="quotation_line_approve_name">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_details">Details</label>
                                    <textarea class="form-control" id="edit_quotation_line_approve_details" name="quotation_line_approve_details" rows="4"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="quotation_line_approve_lv">Approve level</label>
                                    <input type="number" class="form-control" id="edit_quotation_line_approve_lv" name="quotation_line_approve_lv" min="1" max="99" placeholder="1 - 99" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_quotation_line_approve_status" name="quotation_line_approve_status" value="1" checked>
                                        <label class="custom-control-label" for="edit_quotation_line_approve_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">Position</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_position_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Approve name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_quotation_line_approve_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Details</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_quotation_line_approve_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Approve level</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_quotation_line_approve_lv" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_quotation_line_approve_status" class="col-form-label"></label>
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
    var tableQuotationLineApprove = $('#tableQuotationLineApprove').dataTable({
        "ajax": {
            "url": url_gb + "/admin/QuotationLineApprove/Lists",
            "type": "POST",
            "data": function(d) {
                d.position_id = $('#search_position_id').val();
                d.quotation_line_approve_name = $('#search_quotation_line_approve_name').val();
                d.quotation_line_approve_lv = $('#search_quotation_line_approve_lv').val();
                // etc
            }
        },
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
            $(".change-status").bootstrapToggle();
        },
        "retrieve": true,
        "columns": [
            // {"data" : "checkbox" , "class":"text-center" , "searchable": false, "sortable": false,},
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
                "data": "position_name",
                "class": "text-left"
            },
            {
                "data": "quotation_line_approve_name",
                "class": "text-left"
            },
            {
                "data": "quotation_line_approve_details",
                "class": "text-left",
                "searchable": false,
                "sortable": false,
            },
            {
                "data": "quotation_line_approve_lv",
                "class": "text-center"
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
        "order": [
            [4, "asc"]
        ],
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
        tableQuotationLineApprove.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_position_id').val('').change();
        $('#search_quotation_line_approve_name').val('');
        $('#search_quotation_line_approve_lv').val('');
        tableQuotationLineApprove.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_quotation_line_approve_status').prop('checked', true);
        $('#ModalAdd').modal('show');
    });

    $('body').on('click', '.btn-edit', function(data) {
        var id = $(this).data('id');
        var btn = $(this);
        $('#edit_id').val(id);
        loadingButton(btn);
        $.ajax({
            method: "GET",
            url: url_gb + "/admin/QuotationLineApprove/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            $("#edit_position_id").val(data.position_id).change();
            $("#edit_quotation_line_approve_name").val(data.quotation_line_approve_name);
            $("#edit_quotation_line_approve_details").val(data.quotation_line_approve_details);
            $("#edit_quotation_line_approve_lv").val(data.quotation_line_approve_lv);
            if (data.quotation_line_approve_status == 1) {
                $('#edit_quotation_line_approve_status').prop('checked', true);
            } else {
                $('#edit_quotation_line_approve_status').prop('checked', false);
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
            url: url_gb + "/admin/QuotationLineApprove/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            if (data.quotation_line_approve_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_position_name').text(data.position.position_name);
            $('#show_quotation_line_approve_name').text(data.quotation_line_approve_name);
            $('#show_quotation_line_approve_details').text(data.quotation_line_approve_details);
            $('#show_quotation_line_approve_lv').text(data.quotation_line_approve_lv);
            $('#show_quotation_line_approve_status').text(status);
            $('#ModalView').modal('show');
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('change', '.change-status', function(data) {
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        $.ajax({
            method: "POST",
            url: url_gb + "/admin/QuotationLineApprove/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableQuotationLineApprove.api().ajax.reload();
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
            url: url_gb + "/admin/QuotationLineApprove",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableQuotationLineApprove.api().ajax.reload();
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
            url: url_gb + "/admin/QuotationLineApprove/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableQuotationLineApprove.api().ajax.reload();
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