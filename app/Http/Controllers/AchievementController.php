<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * @param Request $request
     * @return void
     * 選択された利用者のidを取得できていたら実績データを取得して登録ページへ移動
     */
    public function selection(Request $request)
    {
        //formから送られてきた利用者のidを取得
        /**当月の月初と月末のオブジェクトを作成 */
        $firstOfMonth = Carbon::now()->firstOfMonth();
        $endOfMonth = $firstOfMonth->copy()->endOfMonth();

        //送られてきた値から月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->addMonth($request->month)->daysInMonth;

        //実績データの登録日と当月の日数とを比較する値の作成
        $day = new Carbon($firstOfMonth);
        $formatday = 'Y-MM-DD';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }

        //実績表に表示する日数の値の作成
        $formatday = 'DD';
        $dalys[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $dalys[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }

        //実績表に表示する曜日の値の作成
        Carbon::setLocale('ja');
        $week = new Carbon($firstOfMonth);
        $formatweek = 'ddd';
        $weeks[0] = $week->isoFormat($formatweek);
        for ($n = 1; $n < $startday; $n++) {
            $weeks[$n] = $day->copy()->addDay($n)->isoFormat($formatweek);
        }

        /**該当ユーザーの実績データの取得 */
        $users = User::with('achievement')
            ->join('achievements', 'user_id', '=', 'users.id')
            ->where('users.id', $request->id)
            ->whereBetween('insert_date', [$firstOfMonth, $endOfMonth])
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
            ->get();


        //実績データを当月分の連想配列を作成
        $datas = [];
        $i = 0;
        foreach ($days as $day) {
            $day[0];
            $i++;
            array_push($datas, $day);
        }
        //実績データを連想配列に格納
        foreach ($users as $user) {
            for ($n = 0; $n < $startday; $n++) {
                if ($datas[$n] == $user->insert_date) {
                    $datas[$n] = $user;
                }
            }
        }
        if ($users->isEmpty()) {
            return redirect('/');
        } else {
            $data = [
                'users' => $users,
                'datas' => $datas,
                'days' => $days,
                'weeks' => $weeks,
                'dalys' => $dalys,
            ];
            return view('achievement.recode', $data);
        }
    }
    /**
     * 過去の月の日数と曜日を取得
     */
    public function Pastmonth(Request $request)
    {
        $dt_from = Carbon::now()->firstOfMonth()->addMonth($request->month);
        $dt_to = Carbon::now()->endOfMonth()->addMonth($request->month)->addDay(-1);

        //月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->addMonth($request->month)->daysInMonth;
        // dd($startday);

        $day = new Carbon($dt_from);
        $formatday = 'D';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }
        // dd($days);

        // //曜日の取得
        Carbon::setLocale('ja');
        $week = new Carbon($dt_from);
        $formatweek = 'ddd';
        $weeks[0] = $week->isoFormat($formatweek);
        for ($n = 1; $n < $startday; $n++) {
            $weeks[$n] = $day->copy()->addDay($n)->isoFormat($formatweek);
        }
        // dd($weeks);
    }
}
