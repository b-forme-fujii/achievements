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

    
     //利用者登録用のバリデーション
     public static $rules = [
        'first_name' => ['required', 'regex:/^[ぁ-んァ-ヶー一-龠]+$/', 'min:1|max:10'],
        'last_name' => ['required', 'regex:/^[ぁ-んァ-ヶー一-龠]+$/', 'min:1|max:20'],
        'full_name' => ['required', 'regex:/^[ァ-ヾ 　〜ー−]+$/u', 'min:2|max:30'],
        'age' => ['required', 'numeric', 'min:18|max:100'],
    ];

     // バリデーションのエラーメッセージ
     public static $messages = [
        'first_name.required' => '名字を入力して下さい。',
        'first_name.regex' => '全角文字で入力して下さい。',
        'first_name.min' => '1文字以上で入力して下さい。',
        'first_name.max' => '10文字以内で入力して下さい。',

        'last_name.required' => '名前を入力して下さい。',
        'last_name.regex' => '全角文字で入力して下さい。',
        'last_name.min' => '1文字以上で入力して下さい。',
        'last_name.max' => '20文字以内で入力して下さい。',

        'full_name.required' => '必須項目です。',
        'full_name.regex' => '全角カタカナで入力して下さい。',
        'full_name.min' => '2文字以上で入力して下さい。',
        'full_name.max' => '30文字以内で入力して下さい。',
        
        'age.required' => 'メールアドレスを入力して下さい。',
        'age.numeric' => '年齢は数字で入力して下さい。',
        'age.min' => '年齢は18以上で入力して下さい。',
        'age.max' => '年齢は100以下で入力して下さい。',

        'school_id.required' => '所属校を選択して下さい。',
        'school_id.numeric' => 'エラーが発生しました。もう一度選択して下さい。',
    ];
    
    /**
     * 本校の利用者一覧を取得
     */
    public function Users()
    {
        $school_1 = User::where('school_id', 1)
        ->orderBy('full_name','asc')
        ->get();

        $school_2 = User::where('school_id', 2)
        ->orderBy('full_name','asc')
        ->get();

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return ($data);
    }


    /**
     * 該当ユーザーの情報を取得
     */
    public function getUser(Request $request)
    {
        $user = User::where('id',$request->user_id)
        ->first();
        return($user);
    }    
}
