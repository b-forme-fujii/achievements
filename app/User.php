<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    /**
     * 月の実績データの取得処理
     * 
     */
    public function getMonth(Request $request)
    {
        /**当月の月初と月末のオブジェクトを作成 */
        $dt_from = Carbon::now()->firstOfMonth();
        $dt_to = Carbon::now()->endOfMonth();
        
        //月の日数を取得
        $startday = Carbon::now()->firstOfMonth()->addMonth(0)->daysInMonth;

        $day = new Carbon($dt_from);
        $formatday = 'D';
        $days[0] = $day->isoFormat($formatday);

        for ($i = 1; $i < $startday; $i++) {
                $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);    
        }

        // //曜日の取得
        $week = new Carbon($dt_from);
        $formatweek = 'ddd';
        $weeks[0] = $week->isoFormat($formatweek);

        for ($n = 1; $n < $startday; $n++) {
            $weeks[$n] = $day->copy()->addDay($n)->isoFormat($formatweek);
        }
    }

    // /**バリデーションルール */
    // public static $rules = [
    //     'id' => 'required',
    // ];

    // /**バリデーションのエラーメッセージ */
    // public static $messages = [
    //     'id.required' => 'ユーザーを選択してください'
    // ];

    /*
    *achievementsテーブルとusersテーブルをリレーション
    */
    public function achievement()
    {
        return $this->hasMany('App\Achievement');
    }
    
}
