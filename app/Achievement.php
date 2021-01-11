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

    /**
     * achievementsテーブルとusersテーブルをリレーション
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    //当月の日数を取得
    public function getDays()
    {
        /**当月の月初と月末のオブジェクトを作成 */
        $firstOfMonth = Carbon::now()->firstOfMonth();

        //送られてきた値から月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->endOfMonth()->daysInMonth;

        //実績データの登録日と当月の日数とを比較する値の作成
        $day = new Carbon($firstOfMonth);
        $formatday = 'Y-MM-DD';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }
        return $days;
    }

    //当月の日数を取得
    public function getFDays()
    {
        /**当月の月初と月末のオブジェクトを作成 */
        $firstOfMonth = Carbon::now()->firstOfMonth();

        //送られてきた値から月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->endOfMonth()->daysInMonth;

        //実績データの登録日と当月の日数とを比較する値の作成
        $day = new Carbon($firstOfMonth);
        $formatday = 'DD';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }
        return $days;
    }

    //当月の曜日を取得
    public function getweeks()
    {
        /**当月の月初と月末のオブジェクトを作成 */
        $firstOfMonth = Carbon::now()->firstOfMonth();

        //送られてきた値から月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->endOfMonth()->daysInMonth;

        //実績表に表示する曜日の値の作成
        Carbon::setLocale('ja');
        $day = new Carbon($firstOfMonth);
        $week = new Carbon($firstOfMonth);
        $formatweek = 'ddd';
        $weeks[0] = $week->isoFormat($formatweek);
        for ($n = 1; $n < $startday; $n++) {
            $weeks[$n] = $day->copy()->addDay($n)->isoFormat($formatweek);
        }
        return $weeks;
    }
    /**
     * ユーザーの当日の実績データを取得 
     */
    public function getOneRecode(Request $request)
    {
        $now = Carbon::now()->format("Y-m-d");

        $one_recode = Achievement::where('user_id', $request->id)
            ->wheredate('insert_date', $now)
            ->select(
                'achievements.user_id',
                'achievements.insert_date',
                'achievements.start_time',
                'achievements.end_time',
                'achievements.food',
                'achievements.outside_support',
                'achievements.medical__support',
                'achievements.note'
            )
            ->first();
        return $one_recode;
    }

    public function getAchievements(Request $request)
    {
        /**当月の月初と月末のオブジェクトを作成 */
        $firstOfMonth = Carbon::now()->firstOfMonth();
        $endOfMonth = $firstOfMonth->copy()->endOfMonth();

        //送られてきた値から月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->endOfMonth()->daysInMonth;

        //実績データの登録日と当月の日数とを比較する値の作成
        $day = new Carbon($firstOfMonth);
        $formatday = 'Y-MM-DD';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
            $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);
        }

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

        return $recodes;
    }

    //今日の登録日を取得
    public function getDate()
    {
        $date = Carbon::now()->format("Y-m-d");
        return $date;
    }

    //今日の登録時間を取得
    public function getStart_Time()
    {
        $time = Carbon::now();
        $time->addMinutes(15 - $time->minute % 15);
        $time = $time->format("H:i");
        return $time;
    }
}
