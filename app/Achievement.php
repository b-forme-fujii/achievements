<?php

namespace App;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    /**
     * achievementsテーブルとusersテーブルをリレーション
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * ユーザーの今日のデータを取得
     * 
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
            return($one_recode);
    }

}
