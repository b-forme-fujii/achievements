<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * ユーザー選択ページ
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $school_1 = User::where('school_id', 1)
        ->orderBy('full_name','asc')
        ->paginate(10);

        $school_2 = User::where('school_id', 2)
        ->orderBy('full_name','asc')
        ->paginate(10);

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];

        // /**Userモデルのオブジェクト作成 */
        // $user = new User();

        // /**ユーザー情報の取得 */
        // $data = $user->getData();
        return view('achievement.index', $data);
    }

    /**
     * 
     * @param Request $request
     * @return void
     * 選択された利用者のidを取得できていたら実績データを取得して登録ページへ移動
     */
    public function selection(Request $request)
    {
        
        //formから送られてきた利用者のidを取得
        if (isset($request->id)) {
            //idが取得できていたら今日の日付オブジェクトを取得
            $today = new Datetime();

            //実績データの取得
            $users = User::with('achievement')
            
            ->join('achievements','user_id', '=', 'users.id')
            ->where($request->user_id)
            ->orderBy('insert_date', 'asc')
            ->select(
              'users.first_name',
              'users.last_name',
              'achievements.id',
              'achievements.user_id',
              'achievements.insert_date',
              'achievements.start_time',
              'achievements.end_time',
              'achievements.food',
              'achievements.outside_support',
              'achievements.medical__support',
              'achievements.note'
            )
            ->paginate(10);

            $data = [
                'today' => $today,
                'users' => $users,
            ];
            return view('achievement.recode', $data);
        }
        else {
            return redirect('/');
        }
    }
}
