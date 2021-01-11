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

        //該当ユーザーの名前を取得
        $user = new User();
        $user = $user->getUser($request);

        /**該当ユーザーの今日の実績データの取得 */
        $one_recode = new Achievement();
        $one_recode = $one_recode->getOneRecode($request);

        /**該当ユーザーの実績データを全て取得 */
        $achievements = Achievement::with('User')
            ->join('users', 'users.id', '=', 'achievements.user_id')
            ->where('achievements.user_id', $request->id)
            ->whereBetween('insert_date', [$firstOfMonth, $endOfMonth])
            ->orderBy('insert_date', 'asc')
            ->select(
                'achievements.insert_date',
                'achievements.start_time',
                'achievements.end_time',
                'achievements.food',
                'achievements.outside_support',
                'achievements.medical__support',
                'achievements.note'
            )
            ->get();

        //当月の連想配列を複製
        $recodes = $days;
        //実績データの登録日と比較して一致したらその配列を上書き
        foreach ($achievements as $achievement) {
            for ($n = 0; $n < $startday; $n++) {
                if ($recodes[$n] == $achievement->insert_date) {
                    $recodes[$n] = $achievement;
                }
            }
        }
        // dd($datas);
        $data = [
            'user' => $user,
            'one_recode' => $one_recode,
            'recodes' => $recodes,
            'days' => $days,
            'weeks' => $weeks,
            'dalys' => $dalys,
        ];
        return view('achievement.recode', $data);
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
