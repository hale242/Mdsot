<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    protected $table = 'admin_group';
    protected $primaryKey = 'admin_group_id';

    public function GroupLevel(){
        return $this->hasOne('\App\GroupLevel', 'admin_user_group_id', 'admin_user_group_id');
    }
}
