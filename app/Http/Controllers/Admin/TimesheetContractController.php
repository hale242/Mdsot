<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\TimesheetContract;
use App\CustomerContract;

class TimesheetContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = TimesheetContract::find($id);
        $content->timesheet_contract_date = $content->timesheet_contract_date ? date('Y-m-d', strtotime($content->timesheet_contract_date)) : '';
        $content->timesheet_contract_def_time_start = $content->timesheet_contract_def_time_start ? date('Y-m-d\TH:i:s', strtotime($content->timesheet_contract_def_time_start)) : '';
        $content->timesheet_contract_def_time_end = $content->timesheet_contract_def_time_end ? date('Y-m-d\TH:i:s', strtotime($content->timesheet_contract_def_time_end)) : '';
        $return['status'] = 1;
        $return['title'] = 'Get TimesheetContract';
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
        $validator = Validator::make($request->all(), [
            'timesheet_contract_status' => 'required',
            'timesheet_contract_def_time_start' => 'required',
            'timesheet_contract_def_time_end' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $TimesheetContract = TimesheetContract::find($id);
                foreach($input_all as $key=>$val){
                    $TimesheetContract->{$key} = $val;
                }
                $TimesheetContract->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['timesheet_contract_status']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Status is required";
            }
            if(isset($failedRules['timesheet_contract_def_time_start']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Start work is required";
            }
            if(isset($failedRules['timesheet_contract_def_time_end']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Get off work is required";
            }
        }
        $return['title'] = 'Insert';
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
      $result = TimesheetContract::select();
      $customer_contract_id = $request->input('customer_contract_id');
      if($customer_contract_id){
          $result->where('customer_contract_id', $customer_contract_id);
      }
      return Datatables::of($result)
        ->editColumn('timesheet_contract_date_text' , function($res){
            $color = $res->timesheet_contract_date_text ? $res->Color[$res->timesheet_contract_date_text] : '';
            if($res->timesheet_contract_date_text){
                return '<span class="badge badge-pill text-white font-medium label-rouded" id="show_status_job_app_name" style="background-color: '.$color.';">'.$res->timesheet_contract_date_text.'</span> ';
            }
        })
        ->editColumn('timesheet_contract_date' , function($res){
            return $res->timesheet_contract_date ? date('d/m/Y', strtotime($res->timesheet_contract_date)) : '';
        })
        ->editColumn('timesheet_contract_def_time_start' , function($res){
            return $res->timesheet_contract_def_time_start ? date('H:i', strtotime($res->timesheet_contract_def_time_start)) : '';
        })
        ->editColumn('timesheet_contract_def_time_end' , function($res){
            return $res->timesheet_contract_def_time_end ? date('H:i', strtotime($res->timesheet_contract_def_time_end)) : '';
        })
        ->addColumn('timesheet_contract_taxi_start' , function($res){
            $start = $res->timesheet_contract_taxi_morning_start ? date('H:i', strtotime($res->timesheet_contract_taxi_morning_start)) : '';
            $end = $res->timesheet_contract_taxi_morning_end ? date('H:i', strtotime($res->timesheet_contract_taxi_morning_end)) : '';
            return $start.'-'.$end;
        })
        ->addColumn('timesheet_contract_taxi_end' , function($res){
            $start = $res->timesheet_contract_taxi_evening_start ? date('H:i', strtotime($res->timesheet_contract_taxi_evening_start)) : '';
            $end = $res->timesheet_contract_taxi_evening_end ? date('H:i', strtotime($res->timesheet_contract_taxi_evening_end)) : '';
            return $start.'-'.$end;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('CustomerContract' , '1');
            $insert = Helper::CheckPermissionMenu('CustomerContract' , '2');
            $update = Helper::CheckPermissionMenu('CustomerContract' , '3');
            $delete = Helper::CheckPermissionMenu('CustomerContract' , '4');
            if($res->timesheet_contract_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status change-status-timesheet" '.$checked.' data-id="'.$res->timesheet_contract_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit-timesheet" data-id="'.$res->timesheet_contract_id.'">Edit</button>';
            $str = '';
            if($update){
                $str.=' '.$btnStatus;
            }
            if($update){
                $str.=' '.$btnEdit;
            }
            return $str;
        })
        ->addIndexColumn()
        ->rawColumns(['timesheet_contract_date_text', 'action'])
        ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $TimesheetContract = TimesheetContract::find($id);
            $TimesheetContract->timesheet_contract_status = $request->input('status');
            $TimesheetContract->save();
            \DB::commit();
            $return['count_working'] = TimesheetContract::where('customer_contract_id', $TimesheetContract->customer_contract_id)->where('timesheet_contract_status', 1)->count();
            $return['count_workend'] = TimesheetContract::where('customer_contract_id', $TimesheetContract->customer_contract_id)->where('timesheet_contract_status', 0)->count();
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

    public function UpdateTaxiPriceSetting(Request $request, $customer_contract_id)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'timesheet_contract_taxi_morning_start' => 'required',
            'timesheet_contract_taxi_morning_end' => 'required',
            'timesheet_contract_taxi_evening_start' => 'required',
            'timesheet_contract_taxi_evening_end' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                TimesheetContract::where('customer_contract_id', $customer_contract_id)->update([
                    'timesheet_contract_taxi_morning_start' => date('Y-m-d').' '.$input_all['timesheet_contract_taxi_morning_start'],
                    'timesheet_contract_taxi_morning_end' => date('Y-m-d').' '.$input_all['timesheet_contract_taxi_morning_end'],
                    'timesheet_contract_taxi_evening_start' => date('Y-m-d').' '.$input_all['timesheet_contract_taxi_evening_start'],
                    'timesheet_contract_taxi_evening_end' => date('Y-m-d').' '.$input_all['timesheet_contract_taxi_evening_end'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['timesheet_contract_taxi_morning_start']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Start time shift is required";
            }
            if(isset($failedRules['timesheet_contract_taxi_morning_end']['required'])) {
                $return['status'] = 2;
                $return['title'] = "To is required";
            }
            if(isset($failedRules['timesheet_contract_taxi_evening_start']['required'])) {
                $return['status'] = 2;
                $return['title'] = "End time shift is required";
            }
            if(isset($failedRules['timesheet_contract_taxi_evening_end']['required'])) {
                $return['status'] = 2;
                $return['title'] = "To is required";
            }
        }
        $return['title'] = 'Insert';
        return $return;
    }

    public function UpdateShift(Request $request, $customer_contract_id)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $timesheet_contract_date_start = $request->input('timesheet_contract_date_start');
                $timesheet_contract_date_end = $request->input('timesheet_contract_date_end');
                $ttimesheet_contract_day = $request->input('timesheet_contract_day');
                $result = TimesheetContract::where('customer_contract_id', $customer_contract_id);
                if($timesheet_contract_date_start && $timesheet_contract_date_end){
                    $result->whereBetween('timesheet_contract_date', [$timesheet_contract_date_start.' 00:00:00', $timesheet_contract_date_end.' 23:59:59']);
                }elseif($timesheet_contract_date_start && !$timesheet_contract_date_end){
                    $result->whereBetween('timesheet_contract_date', [$timesheet_contract_date_start.' 00:00:00', $timesheet_contract_date_start.' 23:59:59']);
                }elseif(!$timesheet_contract_date_start && $timesheet_contract_date_end){
                    $result->whereBetween('timesheet_contract_date', [$timesheet_contract_date_end.' 00:00:00', $timesheet_contract_date_end.' 23:59:59']);
                }
                if($ttimesheet_contract_day){
                    $result->whereIn('timesheet_contract_date_text', $ttimesheet_contract_day);
                }else{
                    $result->whereNull('timesheet_contract_date_text');
                }
                if($request->input('type') == 'S'){ // submit
                    $result->update([
                        'timesheet_contract_def_time_start' => date('Y-m-d').' '.$request->input('timesheet_contract_def_time_start'),
                        'timesheet_contract_def_time_end' => date('Y-m-d').' '.$request->input('timesheet_contract_def_time_end'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }elseif($request->input('type') == 'R'){ // reset
                    $CustomerContract = CustomerContract::find($customer_contract_id);
                    $result->update([
                        'timesheet_contract_def_time_start' => date('Y-m-d').' '.$CustomerContract->customer_contract_time_start,
                        'timesheet_contract_def_time_end' => date('Y-m-d').' '.$CustomerContract->customer_contract_time_end,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Insert';
        return $return;
    }
}
