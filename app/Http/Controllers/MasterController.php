<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    //利用者情報を在籍校別で取得
    public function master_index()
    {
        //本校のユーザー情報の取得
        $school_1 = new User();
        $school_1 = $school_1->School_1();

        //2校のユーザー情報の取得
        $school_2 = new User();
        $school_2 = $school_2->School_2();

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return view('master.master_index', $data);
    }

    //指定した利用者の実績データの取得
    public function get_recodes(Request $request)
    {
        //本校のユーザー情報の取得
        $school_1 = new User();
        $school_1 = $school_1->School_1();
        
        //2校のユーザー情報の取得
        $school_2 = new User();
        $school_2 = $school_2->School_2();
        
        //年度取得
        $year = new Achievement();
        $year = $year->getYear($request);
        
        //何月かを取得
        $month = new Achievement();
        $month = $month->getMonth($request);
        
        //当月の日数を取得
        $days = new Achievement();
        $days = $days->getDays($request);
        
        //当月の日数($daysとは別のフォーマット形式)を取得
        $fdays = new Achievement();
        $fdays = $fdays->getFDays($request);
        
        //当月の曜日を取得
        $weeks = new Achievement();
        $weeks = $weeks->getweeks($request);
        
        //今月から過去1年間の月を取得
        $pmonths = new Achievement();
        $pmonths = $pmonths->PMonths();
        
        $nums = new Achievement();
        $nums = $nums->Mnum();
        
        //該当ユーザーの情報をを取得
        $user = new User();
        $user = $user->getUser($request);


        //該当ユーザーの月の実績データの取得
        $recodes = new Achievement();
        $recodes = $recodes->getAchievements($request);
        
        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
            'year' => $year,
            'month' => $month,
            'days' => $days,
            'fdays' => $fdays,
            'weeks' => $weeks,
            'pmonths' => $pmonths,
            'nums' => $nums,
            'user' => $user,
            'recodes' => $recodes,
        ];
        return view('master.master_index', $data);
    }
}
