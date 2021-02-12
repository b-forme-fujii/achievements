<?php

namespace App\Http\Controllers;

use App\User;
use App\Master;
use App\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * 利用者の実績ページ
     * @param Request $request
     * @return void
     * 実績データと当月の日数、曜日、使用する引数を取得して登録ページへ移動
     */
    public function selection(Request $request)
    {
        //月初を取得
        $month = new Achievement();
        $month = $month->Beginning($request);

        //当月の日数を取得
        $days = new Achievement();
        $days = $days->One_Month($request);

        //今月から過去1年間の月を取得
        $years = new Achievement();
        $years = $years->One_Year();

        $nums = new Achievement();
        $nums = $nums->Manth_Nums();

        //該当ユーザーの情報をを取得
        $user = new User();
        $user = $user->getUser($request);

        //利用者の当日の実績データを取得 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

        //該当ユーザーの月の実績データの取得
        $records = new Achievement();
        $records = $records->Month_Records($request);

        $data = [
            'month' => $month,
            'days' => $days,
            'years' => $years,
            'nums' => $nums,
            'user' => $user,
            'one_record' => $one_record,
            'records' => $records,
        ];
        return view('achievement.record', $data);
    }

    /**
     * 実績テーブルに新規レコードを作成
     * @param Request $request
     * @return void
     * 当日の開始時刻と登録日を作成
     */
    public function new_record(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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
     * @param Request $request
     * @return void
     */
    public function end_time(Request $request)
    {

        //該当ユーザーの今日の実績データを検索
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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
     * @param Request $request
     * @return void
     */
    public function food_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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
     * @param Request $request
     * @return void
     */
    public function outside_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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
     * @param Request $request
     * @return void
     */
    public function medical_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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
     * @param Request $request
     * @return void
     */
    public function note_up(Request $request)
    {
        //該当ユーザーの今日の実績データを検索 
        $one_record = new Achievement();
        $one_record = $one_record->One_Record($request);

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

    /**
     * 利用者実績の作成ページへ移動
     * @param Request $request
     * @return void
     */
    public function add_achievement(Request $request)
    {
        //利用者情報を取得
        $user = new User();
        $user = $user->getUser($request);

        return view('master.add_achievement', $user);
    }

    /**
     * 利用者実績の作成を実行
     * @param Request $request
     * @return void
     */
    public function create_achievement(Request $request)
    {
        // dd($request->insert_date);
        //該当ユーザーの当日レコードが存在しないかをチェック
        $one_record = Achievement::where('user_id', $request->user_id)
            ->wheredate('insert_date', $request->insert_date)
            ->first();
        //当日のレコードが存在していた場合セッションにメッセージを保存して戻る
        if ($one_record != null) {
            return back()
                ->withInput()
                ->with('error', '既に実績データが登録されています。');
        } else {

            //Achievementモデルのオブジェクト作成
            $achievement = new Achievement();
            //formの内容を全て取得
            $form = $request->all();
            //内容を更新して保存
            $achievement->fill($form)->save();
            //実績閲覧ページにリダイレクト   
            return redirect('/master');
        }
    }

    /**
     * 実績編集ページ
     * @pahram Request $request
     * @return void
     * idからレコードを抽出して編集ページに渡す
     */
    public function edit_achievement(Request $request)
    {
        $user = new User();
        $user = $user->getUser($request); 

        $record = Achievement::
            where('achievements.id', $request->id)
            ->first();

            $data = [
                'user' => $user,
                'record' => $record,
            ];
        return view('master.edit_achievement', $data);
    }

    /**
     * 実績編集を実行
     * @pahram Request $request
     * @return void
     * idからレコードを抽出して各項目を編集
     */
    public function update_achievement(Request $request)
    {
        //Achievementモデルのオブジェクト作成
        $achievement = Achievement::where('id', $request->id)
            ->first();
        //formの内容を全て取得
        $form = $request->all();
        //内容を更新して保存
        $achievement->fill($form)->save();

        //該当利用者の当月の実績データを取得
        $data = new Master();
        $data = $data->Records($request);

        //実績閲覧ページにリダイレクト   
        return view('master.master_index', $data);
    }

    /**
     * 実績編集を実行
     * @pahram Request $request
     * @return void
     * idからレコードを抽出して各項目を編集
     */
    public function del_conf(Request $request)
    {
        //Achievementモデルのオブジェクト作成
        $achievement = Achievement::where('id', $request->id)
            ->first();
        //formの内容を全て取得
        $form = $request->all();
        //内容を更新して保存
        $achievement->fill($form)->save();

        //該当利用者の当月の実績データを取得
        $data = new Master();
        $data = $data->Records($request);

        //実績閲覧ページにリダイレクト   
        return view('master.master_index', $data);
    }

    public function delete_achievement(Request $request)
    {
        $record = Achievement::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->first();

        if (is_null($record)) {
            //該当実績データがない場合
            return redirect('/master');
        } else {
            //存在していた場合削除処理を実行
            $record->delete();
            
            //該当利用者の当月の実績データを取得
            $data = new Master();
            $data = $data->Records($request);

            //実績閲覧ページにリダイレクト   
            return view('master.master_index', $data);
        }
    }
}
