<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class Master extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *　利用者一覧と当月の実績データと実績表に必要なデータを取得
     * @pahram Request $request
     * @return void
     * 在籍校別で利用者情報を取得する
     */
    public function Records(Request $request)
    {

        //本校のユーザー情報の取得
        $school_1 = new User();
        $school_1 = $school_1->School_1();

        //2校のユーザー情報の取得
        $school_2 = new User();
        $school_2 = $school_2->School_2();

        //月初を取得
        $month = new Achievement();
        $month = $month->Beginning($request);

        //当月の日数を取得
        $days = new Achievement();
        $days = $days->One_Month($request);

        //今月から過去1年間の月を取得
        $years = new Achievement();
        $years = $years->One_Year();

        //過去の月の実績表を取得するための引数を取得
        $nums = new Achievement();
        $nums = $nums->Manth_Nums();

        //該当ユーザーの情報をを取得
        $user = new User();
        $user = $user->getUser($request);

        //該当ユーザーの月の実績データの取得
        $records = new Achievement();
        $records = $records->Month_Records($request);

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
            'month' => $month,
            'days' => $days,
            'years' => $years,
            'nums' => $nums,
            'user' => $user,
            'records' => $records,
        ];
        return ($data);
    }
}
