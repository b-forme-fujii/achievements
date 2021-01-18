<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    protected $fillable = array('school_id', 'first_name', 'last_name', 'full_name', 'age');
    
    /**
     * 本校の利用者一覧を取得
     */
    public function School_1()
    {
        $school_1 = User::where('school_id', 1)
        ->orderBy('full_name','asc')
        ->get();
        return $school_1;
    }

     /**
     * 2校の利用者一覧を取得
     */
    public function School_2()
    {
        $school_2 = User::where('school_id', 2)
        ->orderBy('full_name','asc')
        ->get();
        return $school_2;
    }

    /**
     * 該当ユーザーのfirst_nameとlast_nameを取得
     */
    public function getUser(Request $request)
    {
        $user = User::where('id',$request->user_id)
        ->select(
            'users.id',
            'users.school_id',
            'users.first_name',
            'users.last_name',
        )->first();
        return($user);
    }    
}
