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

    //月の日数が何日かを取得
    public function D_Month(Request $request)
    {
        $dmonth = new Carbon($request->month);
        $dmonth = $dmonth->daysInMonth;
        return $dmonth;
    }

    /**
     * 一ヶ月分の日数を取得
     */
    public function M_Days(Request $request)
    {
        //月初を取得
        $bmonth = new Carbon($request->month);

        //月の日数が何日かを取得
        $dmonth = new Master();
        $dmonth = $dmonth->D_Month($request);

        //日付を連想配列に格納
        for ($i = 0; $i < $dmonth; $i++) {
            $days[$i] = $bmonth->copy()->addDay($i);
        }
        return ($days);
    }

    /**
     * Excelの日付、曜日、サービス提供欄出力用の連想配列を作成
     * 
     */
    public function Excel_Days(Request $request)
    {
        // 一ヶ月分の日数を取得
        $mdays = new Master();
        $mdays = $mdays->M_Days($request);

        //mdaysをネストして新たな配列に
        //0 => array:3 [▼
        //  0 => "日付、"
        //  1 => "曜日"
        //  2 => "欠or空文字
        //を格納
        foreach ($mdays as $day) {
            if ($day->isSaturday() || $day->isSunday()) {
                $days[] = array(
                    $day->isoFormat('D日'),
                    $day->isoFormat('ddd'),
                    ""
                );
            } else {
                $days[] = array(
                    $day->isoFormat('D日'),
                    $day->isoFormat('ddd'),
                    "欠"
                );
            }
        }
        return $days;
    }

    //一ヶ月分の実績データの配列を作成
    public function Month_Records(Request $request)
    {
        //月初を取得
        $bmonth = new Carbon($request->month);

        //月の日数が何日かを取得
        $dmonth = new Master();
        $dmonth = $dmonth->D_Month($request);

        //一ヶ月分の日数を取得
        $mdays = new Master();
        $mdays = $mdays->M_Days($request);

        //中身がnullの配列を作成
        $records = null;

        //配列を日数分作成
        for ($n = 0; $n < $dmonth; $n++) {
            $records[][$n] = null;
        }

        //利用者の一ヶ月間のレコードを取得
        $achievements = Achievement::where('achievements.user_id', $request->user_id)
            ->whereYear('insert_date', $bmonth)
            ->whereMonth('insert_date', $bmonth)
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

        //実績データの登録日と一ヶ月の日数を比較して一致した場合$recordsの配列にレコードを上書きする
        foreach ($achievements as $achievement) {
            //開始時間と終了時間を切り取って変換
            $achievement['start_time'] = substr($achievement['start_time'], 0, 5);
            $achievement['end_time'] = substr($achievement['end_time'], 0, 5);
            for ($n = 0; $n < $dmonth; $n++) {
                if ($mdays[$n] == $achievement['insert_date']) {
                    $records[$n] = $achievement;
                }
            }
        }
        return $records;
    }
}
