<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use App\Master;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    //利用者情報を在籍校別で取得
    public function master_index(Request $request)
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

    public function check_records(Request $request)
    {
        $data = new Master();
        $data = $data->Records($request);

        return view('master.master_index', $data);
    }
}
