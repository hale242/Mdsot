@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Search</h4>
                <button id="swapSearch" type="button" class="btn btn-outline-secondary m-t-10 mb-0 mr-1 float-right newdata showSerach showSearch" data-toggle="collapse" href="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                    <span class="ti-angle-down"></span>
                </button>
                <div class="collapse" id="collapseExample">
                    <form id="FormSearch" class="needs-validation" novalidate>
                        <div class="row pt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="search_driver_name">ชื่อ</label>
                                    <input type="text" id="search_driver_name" class="form-control search_table">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="search_driver_lastname">นามสกุล</label>
                                    <input type="text" id="search_driver_lastname" class="form-control search_table">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="search_recruitment_position_id">Position</label>
                                    <select class="form-control custom-select select2" id="search_recruitment_position_id" name="driver[recruitment_position_id]" required>
                                        <option value="">เลือกตำแหน่งงาน</option>
                                        @foreach($RecruitmentPositions as $val)
                                        <option value="{{$val->recruitment_position_id}}">{{$val->recruitment_position_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_driver_status_job_app">สถานะสัมภาษณ์</label>
                                    <select class="form-control custom-select select2" id="search_driver_status_job_app">
                                        <option value="">เลือกสถานะสัมภาษณ์</option>
                                        @foreach($StatusJobApps as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="search_driver_interview_date">วันที่สัมภาษณ์</label>
                                    <input type="date" id="search_driver_interview_date" class="form-control search_table">
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
                </div>
                <div class="table-responsive">
                    <div class="action-tables">

                    </div>
                    <table id="tableInterview" class="table" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 90px;">Actions</th>
                                <th scope="col"></th>
                                <th scope="col">No</th>
                                <th scope="col">ชื่อ - นามสกุล</th>
                                <th scope="col">Position</th>
                                <th scope="col">เงินเดือนทดแทน</th>
                                <th scope="col">Interview date</th>
                                <th scope="col">ผลการสัมภาษณ์</th>
                                <th scope="col">เงินประกัน</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('modal')
@include('admin.JobRegister.Modal.modal_job_register_view')
@include('admin.SignContract.Modal.modal_attach_contract')
@endsection
@section('scripts')
<script>
    var tableInterview = $('#tableInterview').dataTable({
        "ajax": {
            "url": url_gb + "/admin/SignContract/Lists",
            "type": "POST",
            "data": function(d) {
                d.driver_id = $('#add_driver_id').val();
                d.driver_name = $('#search_driver_name').val();
                d.driver_lastname = $('#search_driver_lastname').val();
                d.recruitment_position_id = $('#search_recruitment_position_id').val();
                d.driver_status_job_app = $('#search_driver_status_job_app').val();
                d.driver_interview_date = $('#search_driver_interview_date').val();
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
                "data": "name_th",
                "name": "driver_name_th"
            },
            {
                "data": "name_en",
                "name": "driver_name_en"
            },
            {
                "data": "recruitment_position_name",
                "name": "recruitment_position.recruitment_position_name"
            },
            {
                "data": "driver_expected_salary",
                "class": "text-right",
                "searchable": false
            },
            {
                "data": "driver_interview_date",
                "class": "text-center",
                "searchable": false
            },
            {
                "data": "status",
                "class": "text-center",
                "searchable": false
            },
            {
                "data": "money_guarantee",
                "class": "text-center",
                "searchable": false
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

    $('body').on('change', '.change-status', function(data) {
        var id = $(this).data('id');
        var status = $(this).is(':checked');
        $.ajax({
            method: "POST",
            url: url_gb + "/admin/SignContract/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                DriverContractFileDatatable();
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('click', '.btn-search', function(data) {
        tableInterview.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function(data) {
        $('#search_driver_name').val('');
        $('#search_driver_lastname').val('');
        $('#search_recruitment_position_id').val('').change();
        $('#search_driver_status_job_app').val('').change();
        $('#search_driver_interview_date').val('');
        tableInterview.api().ajax.reload();
    });
</script>
@include('admin.JobRegister.Script.script_job_register_view')
@include('admin.SignContract.Script.script_attach_contract')
@endsection