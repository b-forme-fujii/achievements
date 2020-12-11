<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');


    // /**バリデーションルール */
    // public static $rules = [
    //     'id' => 'required',
    // ];

    // /**バリデーションのエラーメッセージ */
    // public static $messages = [
    //     'id.required' => 'ユーザーを選択してください'
    // ];

    // public function user()
    // {
    //     return $this->hasMany('App\user', 'school_id');
    // }

    /**achievementsテーブルとusersテーブルをリレーション*/
    public function achievement()
    {
        return $this->hasMany('App\Achievement');
    }
    
}
