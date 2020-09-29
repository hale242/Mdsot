<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\OtherExpenses;
use App\ItemCode;

class OtherExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'OtherExpenses')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['ItemCodes'] = ItemCode::where('item_code_status', 1)->get();
        if (Helper::CheckPermissionMenu('OtherExpenses', '1')) {
            return view('admin.OtherExpenses.other_expenses', $data);
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
        $validator = Validator::make($request->all(), [
            'other_expenses_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $OtherExpenses = new OtherExpenses;
                foreach ($input_all as $key => $val) {
                    $OtherExpenses->{$key} = $val;
                }
                if (!isset($input_all['other_expenses_status'])) {
                    $OtherExpenses->other_expenses_status = 0;
                }
                $OtherExpenses->save();
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
            if (isset($failedRules['other_expenses_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Other Expenses is required";
            }
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
        $content = OtherExpenses::with('ItemCode')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get OtherExpenses';
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
            'other_expenses_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $OtherExpenses = OtherExpenses::find($id);
                foreach ($input_all as $key => $val) {
                    $OtherExpenses->{$key} = $val;
                }
                if (!isset($input_all['other_expenses_status'])) {
                    $OtherExpenses->other_expenses_status = 0;
                }
                $OtherExpenses->save();
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
            if (isset($failedRules['other_expenses_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Other Expenses is required";
            }
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
        $result = OtherExpenses::select(
            'other_expenses.*',
            'item_code.item_code_name'
        )
        ->leftjoin('item_code', 'item_code.item_code_id', 'other_expenses.item_code_id');
        return Datatables::of($result)
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('OtherExpenses', '1');
                $insert = Helper::CheckPermissionMenu('OtherExpenses', '2');
                $update = Helper::CheckPermissionMenu('OtherExpenses', '3');
                $delete = Helper::CheckPermissionMenu('OtherExpenses', '4');
                if ($res->other_expenses_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->other_expenses_id . '" data-style="ios" data-on="On" data-off="Off">';
                  
               $str = '<div class="bootstrap-table">';
                $str .= '<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">';
                $str .= '<i class="fas fa-ellipsis-h"></i></button>';
                $str .= '<div class="dropdown-menu float-left" x-placement="bottom-start" >';
                if ($view) {
                    $str .= '<a class="dropdown-item btn-view" href="javascript:void(0)" data-toggle="modal" data-target="#ViewModal" data-id="' . $res->other_expenses_id . '">View</a>';
                }
                if ($update) {
                $str .= '<a class="dropdown-item btn-edit" href="javascript:void(0)" data-toggle="modal" data-target="#EditModal" data-id="' . $res->other_expenses_id . '">Edit</a>';
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
            $input_all['other_expenses_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            OtherExpenses::where('other_expenses_id', $id)->update($input_all);
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
