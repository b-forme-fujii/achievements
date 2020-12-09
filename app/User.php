<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    /**所属校別ユーザー情報を取得 */
    public function getData() {
        $school_1 = User::with('user')
        ->where('users.school_id', 1)
        ->orderBy('users.full_name','asc')
        ->paginate(10);

        $school_2 = User::with('user')
        ->where('users.school_id', 2)
        ->orderBy('users.full_name','asc')
        ->paginate(10);
        
        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return $data;
    }

    /**バリデーションルール */
    public static $rules = [
        'id' => 'required',
    ];

    /**バリデーションのエラーメッセージ */
    public static $messages = [
        'id.required' => 'ユーザーを選択してください'
    ];

    /**achievementsテーブルとusersテーブルをリレーション*/
    public function Achievement()
    {
        return $this->hasMany('App\Achievement');
    }
    
}
