<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\InterviewRecuritApprove;
use App\AdminUser;

class RecruitApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'RecruitApprove')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['AdminUsers'] = AdminUser::get();
        if (Helper::CheckPermissionMenu('RecruitApprove', '1')) {
            return view('admin.RecruitApprove.recruit_approve', $data);
        } else {
            return redirect('admin/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), []);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $InterviewRecuritApprove = new InterviewRecuritApprove;
                foreach ($input_all as $key => $val) {
                    $InterviewRecuritApprove->{$key} = $val;
                }
                if (!isset($input_all['interview_recurit_approve_status'])) {
                    $InterviewRecuritApprove->interview_recurit_approve_status = 0;
                }
                $InterviewRecuritApprove->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Insert';
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = InterviewRecuritApprove::with('AdminUser')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get InterviewRecuritApprove';
        $return['content'] = $content;
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), []);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $InterviewRecuritApprove = InterviewRecuritApprove::find($id);
                foreach ($input_all as $key => $val) {
                    $InterviewRecuritApprove->{$key} = $val;
                }
                if (!isset($input_all['interview_recurit_approve_status'])) {
                    $InterviewRecuritApprove->interview_recurit_approve_status = 0;
                }
                $InterviewRecuritApprove->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update';
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lists(Request  $request)
    {
        $result = InterviewRecuritApprove::select(
            'interview_recurit_approve.*',
            'admin_user.first_name',
            'admin_user.last_name'
        )
            ->leftjoin('admin_user', 'admin_user.admin_id', 'interview_recurit_approve.admin_id');
        $admin_id = $request->input('admin_id');
        $interview_recurit_approve_lv = $request->input('interview_recurit_approve_lv');
        $interview_recurit_approve_date_next = $request->input('interview_recurit_approve_date_next');
        if ($admin_id) {
            $result->where('interview_recurit_approve.admin_id', $admin_id);
        };
        if ($interview_recurit_approve_lv) {
            $result->where('interview_recurit_approve.interview_recurit_approve_lv', $interview_recurit_approve_lv);
        };
        if ($interview_recurit_approve_date_next) {
            $result->where('interview_recurit_approve.interview_recurit_approve_date_next', $interview_recurit_approve_date_next);
        };
        return Datatables::of($result)
            ->addColumn('admin_name', function ($res) {
                return $res->first_name . ' ' . $res->last_name;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('RecruitApprove', '1');
                $insert = Helper::CheckPermissionMenu('RecruitApprove', '2');
                $update = Helper::CheckPermissionMenu('RecruitApprove', '3');
                $delete = Helper::CheckPermissionMenu('RecruitApprove', '4');
                if ($res->interview_recurit_approve_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->interview_recurit_approve_id . '" data-style="ios" data-on="On" data-off="Off">';
                // $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->interview_recurit_approve_id.'">View</button>';
                // $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->interview_recurit_approve_id.'">Edit</button>';
                // $str = '';
                // if($update){
                //     $str.=' '.$btnStatus;
                // }
                // if($view){
                //     $str.=' '.$btnView;
                // }
                // if($update){
                //     $str.=' '.$btnEdit;
                // }
                // return $str;
               $str = '<div class="bootstrap-table">';
                $str .= '<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">';
                $str .= '<i class="fas fa-ellipsis-h"></i></button>';
                $str .= '<div class="dropdown-menu float-left" x-placement="bottom-start" >';
                if ($view) {
                    $str .= '<a class="dropdown-item btn-view" href="javascript:void(0)" data-toggle="modal" data-target="#ViewModal" data-id="' . $res->interview_recurit_approve_id . '">View</a>';
                }
                if ($update) {
                    $str .= '<a class="dropdown-item btn-edit" href="javascript:void(0)" data-toggle="modal" data-target="#EditModal" data-id="' . $res->interview_recurit_approve_id . '">Edit</a>';
                }
                $str .= '</div>';
                $str .= '</div>';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['interview_recurit_approve_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            InterviewRecuritApprove::where('interview_recurit_approve_id', $id)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }
}
