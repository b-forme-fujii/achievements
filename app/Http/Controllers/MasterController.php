<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MasterController extends Controller
{
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
}
