<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    /**
     * インデックスページ
     *
     * @param Request $request
     * @return void
     * school_id毎のデータベースのレコードの抽出
     * 
     */
    public function index(Request $request)
    {
        $school_1 = User::with('user')
        ->where('users.school_id', 1);

        $school_2 = User::with('user')
        ->where('users.school_id', 2);
        $data = [
            'users' => $school_1,
            'users' => $school_2,
        ];
        return view('achievement.index', $data);
    }
}