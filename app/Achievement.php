<?php

namespace App;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    protected $fillable = array('user_id', 'insert_date', 'start_time', 'end_time', 'food', 'outside_support', 'medical__support', 'note');

    protected $dates = array('insert_date');

    //usersテーブルとリレーション処理
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

     //リクエストで送られてきた値から何月かを取得
     public function Beginning(Request $request)
     {
        //  $date = Carbon::now()->firstOfMonth()->addMonth($request->month);
         $date = Carbon::now()->firstOfMonth()->addMonth($request->month);
         return ($date);
     }

    //リクエストで送られてきた値から日付を取得
    // public function Search_Date(Request $request)
    // {
    //     $date = Carbon::now()->firstOfMonth()->addMonth($request->month);
    //     return ($date);
    // }

    //何月かを取得
    // public function getMonth(Request $request)
    // {
    //     $Month = Carbon::now()->firstOfMonth()->addMonth($request->month);
    //     $Month = $Month->isoformat('M');
    //     return ($Month);
    // }

    //月初を取得
    // public function getFirstofMonth(Request $request)
    // {
    //     $firstOfMonth = Carbon::now()->firstOfMonth()->addMonth($request->month);
    //     $firstOfMonth = $firstOfMonth->isoformat('Y-M-D');
    //     return $firstOfMonth;
    // }

    // //月末を取得
    // public function getEndofMonth(Request $request){
    //     $endofMonth =Carbon::now()->endOfMonth()->addMonth($request->month);
    //     $endofMonth = $endofMonth->isoformat('Y-M-D'); 
    //     return $endofMonth;
    // }

    //月の日数が何日かを取得
    // public function getDaysinMonth(Request $request)
    // {
    //     $dMonth = Carbon::now()->firstOfMonth()->addMonth($request->month)->daysInMonth;
    //     return $dMonth;
    // }

    //当月の日数を取得
    public function getDays(Request $request)
    {
        $firstOfMonth = new Achievement();
        $firstOfMonth = $firstOfMonth->Beginning($request);

        //月の日数が何日かを取得
        $addMonth = new Achievement();
        $addMonth = $addMonth->Beginning($request);
        $addMonth =$addMonth->daysInMonth;

        //実績データの登録日と当月の日数とを比較する値の作成
        for ($i = 0; $i < $addMonth; $i++) {
            $days[$i] = $firstOfMonth->copy()->addDay($i);
        }
        return $days;
    }

    //当月の曜日を取得
    // public function getweeks(Request $request)
    // {
    //     $firstOfMonth = new Achievement();
    //     $firstOfMonth = $firstOfMonth->getFirstofMonth($request);

    //     $dMonth = new Achievement();
    //     $dMonth = $dMonth->getDaysinMonth($request);

    //     //実績表に表示する曜日の値の作成
    //     Carbon::setLocale('ja');
    //     $week = new Carbon($firstOfMonth);
    //     $formatweek = 'ddd';
    //     $weeks[0] = $week->isoFormat($formatweek);
    //     for ($n = 1; $n < $dMonth; $n++) {
    //         $weeks[$n] = $week->copy()->addDay($n)->isoFormat($formatweek);
    //     }
    //     return $weeks;
    // }

    //今月から過去1年間の月を取得
    public function PMonths()
    {
        $firstOfMonth = Carbon::now()->firstOfMonth();

        //実績データの登録日と当月の日数とを比較する値の作成
        $day = new Carbon($firstOfMonth);
        $formatFday = 'Y年M月';
        $Months[0] = $day->isoFormat($formatFday);

        for ($i = 0; $i > -12; $i--) {
            $Months[$i] = $day->copy()->addMonth($i)->isoFormat($formatFday);
        }
        return $Months;
    }

    //過去一年分の引数を作成
    public function Mnum()
    {
        //引数の配列を作成
        // $numbers = array(0,-1,-2,-3,-4,-5,-6,-7,-8,-9,-10,-11);
        // // collectヘルパに配列を渡す
        // $collection = collect($numbers);

        for ($i = 0; $i > -12; $i--) {
            $Mnum[$i] = ($i);
        }
        return $Mnum;
    }

    /**
     * ユーザーの当日の実績データを取得 
     */
    public function getOneRecord(Request $request)
    {
        $now = Carbon::now()->isoformat("Y-M-D");

        $one_record = Achievement::where('user_id', $request->user_id)
            ->wheredate('insert_date', $now)
            ->first();
        return $one_record;
    }

     /**
     * ユーザーの当月の実績データを取得 
     */
    public function getAchievements(Request $request)
    {
        //何年かを取得
        $year = new Achievement();
        $year = $year->Beginning($request);

        //月の日数が何日かを取得
        $addMonth = new Achievement();
        $addMonth = $addMonth->Beginning($request);
        $addMonth =$addMonth->daysInMonth;

        //月の日数
        $recodes = new Achievement();
        $recodes = $recodes->getDays($request);
        

        //該当ユーザーの当月のレコードを取得
        $achievements = Achievement::where('achievements.user_id', $request->user_id)
            ->whereYear('insert_date', $year)
            ->whereMonth('insert_date', $year)
            ->orderBy('insert_date', 'asc')
            ->select(
                'achievements.id',
                'achievements.insert_date',
                'achievements.start_time',
                'achievements.end_time',
                'achievements.food',
                'achievements.outside_support',
                'achievements.medical__support',
                'achievements.note'
            )
            ->get();

        //実績データの登録日と比較して一致したらその配列を上書き
        foreach ($achievements as $achievement) {
            for ($n = 0; $n < $addMonth; $n++) {
                if ($recodes[$n] == $achievement->insert_date) {
                    $recodes[$n] = $achievement;
                }
            }
        }
        return $recodes;
    }

    //当日の実績レコードの作成
    public function New_Record(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        //現在時刻を取得して15分切り上げる
        $start_time = Carbon::now();
        $start_time->addMinutes(15 - $start_time->minute % 15);
        //時刻をフォーマット
        $start_time = $start_time->format("H:i");

        //比較する時間を作成
        $fake_time = new Carbon('09:30:00');
        $fake_time = $fake_time->format("H:i");

        //$start_timeが9時30分以前なら9時30分で登録
        if ($start_time > $fake_time) {
            Achievement::create(
                [
                    'user_id' => $request->user_id,
                    'insert_date' => $insert_date,
                    'start_time' => $start_time,
                ],
            );
            //それ以降は$start_timeの時間で登録
        } elseif ($start_time < $fake_time) {
            Achievement::create(
                [
                    'user_id' => $request->user_id,
                    'insert_date' => $insert_date,
                    'start_time' => $fake_time,
                ],
            );
        }
    }

    //終了時刻を作成してレコードを更新
    public function End_Time(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        //現在時刻を取得して15分切り下げる
        $end_time = Carbon::now();
        $end_time->subMinutes($end_time->minute % 15);
        //時刻をフォーマット
        $end_time = $end_time->format("H:i");

        $fake_time = new Carbon('16:00:00');
        $fake_time = $fake_time->format("H:i");

        //終了時刻が16時前なら$end_timeで終了時間を登録
        if ($end_time < $fake_time) {
            Achievement::where('user_id', $request->user_id)
                ->where('insert_date', $insert_date)
                ->update(
                    ['end_time' => $end_time,]
                );
            //16時以降なら16時で登録
        } elseif ($end_time > $fake_time) {
            Achievement::where('user_id', $request->user_id)
                ->where('insert_date', $insert_date)
                ->update(
                    ['end_time' => $fake_time,]
                );
        }
    }

    //食事提供加算を更新
    public function Food_Up(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        Achievement::where('user_id', $request->user_id)
            ->where('insert_date', $insert_date)
            ->update(
                ['food' => $request->food,]
            );
    }

    //施設外支援を更新
    public function Outside_Up(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        Achievement::where('user_id', $request->user_id)
            ->where('insert_date', $insert_date)
            ->update(
                ['outside_support' => $request->outside,]
            );
    }

    //医療連携体制加算を更新
    public function Medical_Up(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        Achievement::where('user_id', $request->user_id)
            ->where('insert_date', $insert_date)
            ->update(
                ['medical__support' => $request->medical,]
            );
    }

    //備考を更新
    public function Note_Up(Request $request)
    {
        //今日の登録日を取得してフォーマット
        $insert_date = Carbon::now()->format("Y-m-d");

        Achievement::where('user_id', $request->user_id)
            ->where('insert_date', $insert_date)
            ->update(
                ['note' => $request->note,]
            );
    }
}
