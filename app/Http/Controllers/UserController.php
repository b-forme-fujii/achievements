<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * ユーザー選択ページ
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $school_1 = User::where('school_id', 1)
        ->orderBy('full_name','asc')
        ->paginate(10);

        $school_2 = User::where('school_id', 2)
        ->orderBy('full_name','asc')
        ->paginate(10);

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return view('achievement.index', $data);
    }

    /**
     * 
     * @param Request $request
     * @return void
     * 選択された利用者のidを取得できていたら実績データを取得して登録ページへ移動
     */
    public function selection(Request $request)
    {
        //formから送られてきた利用者のidを取得
            /**当月の月初と月末のオブジェクトを作成 */
            $firstOfMonth = Carbon::now()->firstOfMonth();
            $endOfMonth = $firstOfMonth->copy()->endOfMonth();

            //月の日数を取得
            $startday = Carbon::now()->firstOfMonth()->addMonth($request->month)->daysInMonth;
            // dd($startday);

            $day = new Carbon($firstOfMonth);
            $formatday = 'Y-MM-DD';
            $days[0] = $day->isoFormat($formatday);

            for ($i = 1; $i < $startday; $i++) {
                    $days[$i] = $day->copy()->addDay($i)->isoFormat($formatday);    
            }
            // dd($days);
            

             // //曜日の取得
                Carbon::setLocale('ja');
                $week = new Carbon($firstOfMonth);
                $formatweek = 'ddd';
                $weeks[0] = $week->isoFormat($formatweek);
                for ($n = 1; $n < $startday; $n++) {
                    $weeks[$n] = $day->copy()->addDay($n)->isoFormat($formatweek);
                }
                // dd($weeks);

                // $weekdays = array(
                //     'days' => $days,
                //     'weeks' => $weeks,
                //  );
                //  dd($weekdays);

                 /**該当ユーザーの実績データの取得 */
                $users = User::with('achievement')  
                ->join('achievements','user_id', '=', 'users.id')
                ->where('users.id', $request->id)
                ->whereBetween('insert_date', [$firstOfMonth, $endOfMonth])
                ->orderBy('insert_date', 'asc')
                ->select(
                'users.first_name',
                'users.last_name',
                'achievements.id',
                'achievements.user_id',
                'achievements.insert_date',
                'achievements.start_time',
                'achievements.end_time',
                'achievements.food',
                'achievements.outside_support',
                'achievements.medical__support',
                'achievements.note'
                )
                ->get();

                $data = [];
                
                
                foreach($users as $user){
                    if($days != $user->insert_date)
                    $data[] = $user;    
                    }
                dd($data);

                // dd($users);

                // $dates = array_combine($list, $users);
                // dd($dates);

                if($users->isEmpty()) {
                    return redirect('/');

                } else {
                    
                    $data = [
                        'users' => $users,
                        // 'weekdays' => $weekdays,
                        'days' => $days,
                        'weeks' => $weeks,
                    ];          
                    return view('achievement.recode', $data);
                }
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
