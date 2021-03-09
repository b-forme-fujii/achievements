<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Achievement;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

        //本校の利用者情報の取得
        $school_1 = new User();
        $school_1 = $school_1->School_1();

        //2校の利用者情報の取得
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

        //利用者の情報をを取得
        $user = new User();
        $user = $user->getUser($request);

        //利用者の月の実績データの取得
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

    public function Days(Request $request)
    {
        //月初を取得
        $month = new Achievement();
        $month = $month->Beginning($request);

        //月の日数が何日かを取得
        $addMonth = new Achievement();
        $addMonth = $addMonth->Beginning($request);
        $addMonth = $addMonth->daysInMonth;

        $Month = new Achievement();
        $Month = $Month->One_Month($request);

        foreach($Month as $add){   
            $days[] = array($add->isoFormat('D日'),
            $add->isoFormat('ddd'));     
        }
        dd($days);
        return $days;
    }

    public function Attendance(Request $request)
    {
        //月の日数が何日かを取得
        $addMonth = new Achievement();
        $addMonth = $addMonth->Beginning($request);
        $addMonth = $addMonth->daysInMonth;
        for ($i = 0; $i < $addMonth; $i++) {
            
        }
        dd($attendances);
        return $attendances;
    }
    public function Month_Records(Request $request)
    {
        //月初を取得
        $year = new Achievement();
        $year = $year->Beginning($request);

        //月初から月末までを取得
        $days = new Achievement();
        $days = $days->One_Month($request);

        //月の日数を取得
        $addMonth = new Achievement();
        $addMonth = $addMonth->Beginning($request);
        $addMonth = $addMonth->daysInMonth;

        //中身がnullの配列を作成
        $records = null;

        //配列を日数分作成
        for ($n = 0; $n < $addMonth; $n++) {
            $records[][$n] = null;
        }
        // dd($records);

        //利用者の一ヶ月間のレコードを取得
        $achievements = Achievement::where('achievements.user_id', $request->user_id)
            ->whereYear('insert_date', $year)
            ->whereMonth('insert_date', $year)
            ->orderBy('insert_date', 'asc')
            ->select(
                'insert_date',
                'start_time',
                'end_time',
                'visit_support',
                'food',
                'outside_support',
                'medical_support',
                'note',
                'stamp',
            )
            ->get()
            ->toarray();

        //実績データの登録日と一ヶ月の日数を比較して一致した場合nullの配列にレコードを代入
        foreach ($achievements as $achievement) {
            $achievement['start_time'] = substr($achievement['start_time'], 0, 5);
            $achievement['end_time'] = substr($achievement['end_time'], 0, 5);
            for ($n = 0; $n < $addMonth; $n++) {
                if ($days[$n] == $achievement['insert_date']) {
                    $records[$n] = $achievement;
                }
            }
        }
        return $records;
    }
}
