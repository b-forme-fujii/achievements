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
        $days = new Achievement();
        $days = $days->getDays(); 
        
        $weeks = new Achievement();
        $weeks = $weeks->getweeks();
        
        $fdays = new Achievement();
        $fdays = $fdays->getFDays();

        //該当ユーザーの名前を取得
        $user = new User();
        $user = $user->getUser($request);

        /**該当ユーザーの今日の実績データの取得 */
        $one_recode = new Achievement();
        $one_recode = $one_recode->getOneRecode($request);
        $recodes = new Achievement();
        $recodes = $recodes->getAchievements($request);

        // dd($datas);
        $data = [
            'user' => $user,
            'days' => $days,
            'weeks' => $weeks,
            'fdays' => $fdays,
            'one_recode' => $one_recode,
            'recodes' => $recodes,
        ];
        return view('achievement.recode', $data);
    }

    /**
     * 今日の開始時間と登録日を実績テーブルに作成
     */
    public function insert_date(Request $request)
    {
        //今日の登録日を取得
        $insert_date = new Achievement();
        $insert_date = $insert_date->getDate();

        $start_time = new Achievement();
        $start_time = $start_time->getStart_Time();

        Achievement::create(
            [
                'user_id' => $request->id,
                'insert_date' => $insert_date,
                'start_time' => $start_time,
            ],
        );
        $days = new Achievement();
        $days = $days->getDays(); 
        
        $weeks = new Achievement();
        $weeks = $weeks->getweeks();
        
        $fdays = new Achievement();
        $fdays = $fdays->getFDays();

        //該当ユーザーの名前を取得
        $user = new User();
        $user = $user->getUser($request);

        /**該当ユーザーの今日の実績データの取得 */
        $one_recode = new Achievement();
        $one_recode = $one_recode->getOneRecode($request);
        $recodes = new Achievement();
        $recodes = $recodes->getAchievements($request);

        // dd($datas);
        $data = [
            'user' => $user,
            'days' => $days,
            'weeks' => $weeks,
            'fdays' => $fdays,
            'one_recode' => $one_recode,
            'recodes' => $recodes,
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
