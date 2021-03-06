<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionActionByGroup extends Model
{
    protected $table = 'permission_action_by_group';
    protected $primaryKey = 'permission_action_by_group_id';

    public function AdminGroup(){
        return $this->hasMany('App\AdminGroup', 'admin_user_group_id', 'admin_user_group_id');
    }
    public function DepartmentAdminUser(){
        return $this->hasMany('App\DepartmentAdminUser', 'department_id', 'department_id');
    }
}
