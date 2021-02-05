<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * ユーザー選択ページ（スタートページ）
     * 本校と2校別でユーザー情報を取得
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


    /**
     * 新規利用者登録ページへ移動
     */
    public function add_user()
    {
        return view('master.add_user');
    }

    /**
     * 新規利用者の登録処理
     * @param Request $request
     * @return void
     */
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

    /**
     * ユーザー情報編集ページの処理
     * @param Request $request
     * @return void
     * requestでidが送られてきているかで処理を分岐
     */
    public function edit_user(Request $request)
    {
        //user_idがnullだった場合は在籍校別のユーザー情報のみを取得
        if ($request->user_id == null) {
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
            return view('master.edit_user', $data);
        } else {
            //本校のユーザー情報の取得
            $school_1 = new User();
            $school_1 = $school_1->School_1();

            //2校のユーザー情報の取得
            $school_2 = new User();
            $school_2 = $school_2->School_2();

            //ユーザー情報を取得
            $user = new User();
            $user = $user->getUser($request);

            $data = [
                'school_1' => $school_1,
                'school_2' => $school_2,
                'user' => $user,
            ];
            return view('master.edit_user', $data);
        }
    }

    /**
     * ユーザー情報を編集
     * @param Request $request
     * @return void
     */
    public function update_user(Request $request)
    {
        //バリデーションの実行
        $this->validate($request, User::$rules, User::$messages);

        //ユーザー情報を取得
        $user = new User();
        $user = $user->getUser($request);

        /**formの内容を全て取得 */
        $form = $request->all();
        /**内容を更新して保存 */
        $user->fill($form)->save();

        return redirect('/master');
    }
}
