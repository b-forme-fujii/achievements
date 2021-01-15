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
        //年度取得
        $Year = new Achievement();
        $Year = $Year->getYear($request);

        //何月かを取得
        $Month = new Achievement();
        $Month = $Month->getMonth($request);
 
        //当月の日数を取得
        $days = new Achievement();
        $days = $days->getDays($request);

        //当月の日数($daysとは別のフォーマット形式)を取得
        $fdays = new Achievement();
        $fdays = $fdays->getFDays($request);

        //当月の曜日を取得
        $weeks = new Achievement();
        $weeks = $weeks->getweeks($request);

        //該当ユーザーの情報をを取得
        $user = new User();
        $user = $user->getUser($request);

        //該当ユーザーの今日の実績データの取得 
        $one_recode = new Achievement();
        $one_recode = $one_recode->getOneRecord($request);
        
        //該当ユーザーの月の実績データの取得
        $recodes = new Achievement();
        $recodes = $recodes->getAchievements($request);

        // dd($datas);
        $data = [
            'Year' => $Year,
            'Month' => $Month,
            'days' => $days,
            'fdays' => $fdays,
            'weeks' => $weeks,
            'user' => $user,
            'one_recode' => $one_recode,
            'recodes' => $recodes,
        ];
        return view('achievement.record', $data);
    }

    /**
     * 当日の開始時刻と登録日を取得して実績テーブルに新規レコードを作成
     */
    public function new_record(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //データが存在した場合戻る
        if ($one_record != null) {
            return back();
        } else {
            //存在しなかった場合レコードを新規作成して戻る
            $new_record = new Achievement();
            $new_record = $new_record->New_Record($request);
            return back();
        }
    }
    
    /**
     * 当日の終了時刻を取得してレコードに追加
     */
    public function end_time(Request $request){

        //該当ユーザーの今日の実績データを検索
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //当日のデータのend_timeの値がnullでなかった場合は戻る
        if ($one_record->end_time != null) {
            return back();
        } else {
            //nullだった場合レコードに終了時刻を登録して戻る
            $end_time = new Achievement();
            $end_time = $end_time->End_Time($request);
            return back();
        }
    }

    /**
     * 食事提供加算の更新処理
     */
    public function food_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //データが存在した場合食事提供加算のレコードを更新して戻る
        if ($one_record != null) {
            $food = new Achievement();
            $food = $food->Food_Up($request);
            return back();
        } else {
            //存在しなかった場合戻る
            return back();
        }
    }

    /**
     * 施設外支援の更新処理
     */
    public function outside_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //データが存在した場合食事提供加算のレコードを更新して戻る
        if ($one_record != null) {
            $outside = new Achievement();
            $outside = $outside->Outside_Up($request);
            return back();
        } else {
            //存在しなかった場合戻る
            return back();
        }
    }

    /**
     * 医療連携体制加算の更新処理
     */
    public function medical_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //データが存在した場合食事提供加算のレコードを更新して戻る
        if ($one_record != null) {
            $medical = new Achievement();
            $medical = $medical->Medical_up($request);
            return back();
        } else {
            //存在しなかった場合戻る
            return back();
        }
    }

    /**
     * 備考の更新処理
     */
    public function note_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->getOneRecord($request);

        //データが存在した場合食事提供加算のレコードを更新して戻る
        if ($one_record != null) {
            $note = new Achievement();
            $note = $note->Note_Up($request);
            return back();
        } else {
            //存在しなかった場合戻る
            return back();
        }
    }
}
