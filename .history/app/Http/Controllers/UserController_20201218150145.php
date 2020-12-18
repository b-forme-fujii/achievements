<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Calendar\CalendarView;

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
            /**当月の月初と月末のオブジェクトを作成 */
            $dt_from = Carbon::now()->firstOfMonth();
            $dt_to = Carbon::now()->endOfMonth();
            
            $startday = Carbon::now()->daysInMonth;
            // dd($startday);

            $day = new Carbon();
            $format = '(Y/m/d(D)))';
            $days = [];

            for ($i = 1; $i <= $startday; $i++) {
                $days[$i] = $day->isoFormat($format);
            }
            dd($days);

            // $calendar

            /** 前月取得 */
            // $add_Month = Carbon::now()->firstOfMonth()->addMonth(-1);
            
            /**該当ユーザーの実績データの取得 */
            $users = User::with('achievement')  
            ->join('achievements','user_id', '=', 'users.id')
            ->where('users.id', $request->id)
            ->whereBetween('insert_date', [$dt_from, $dt_to])
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
                'users' => $users,
            ];
            return view('achievement.recode', $data);
        } else {
            return redirect('/');
        }
    }
}
