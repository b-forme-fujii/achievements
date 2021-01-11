<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    public function achievement()
    {
        return $this->hasMany('App\Achievement');
    }
    /**
     * 該当ユーザーのfirst_nameとlast_nameを取得
     */
    public function getUser(Request $request)
    {
        $user = User::where('id',$request->id)
        ->select(
            'users.id',
            'users.first_name',
            'users.last_name',
        )->first();
        return($user);
    }    
}
