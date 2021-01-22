<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * ユーザー選択ページ
     * @param Request $request
     * @return void
     */
    public function index()
    {
       //本校のユーザー情報の取得
       $school_1 = new User();
       $school_1 = $school_1->School_1();

       //2校のユーザー情報の取得
       $school_2 = new User();
       $school_2 = $school_2->School_2();

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return view('achievement.index', $data);
    }

    //新規利用者登録ページへ移動
    public function add_user()
    {
        return view('master.add');
    }

    //新規利用者の登録
    public function create_user(Request $request)
    {
        //バリデーションの実行
        $this->validate($request, User::$rules, User::$messages);

         User::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'full_name' => $request->full_name,
                'age' => $request->age,
                'school_id' => $request->school_id
            ],
        );


         // 一覧表示画面へリダイレクト
         return redirect('/master');
    }
}
