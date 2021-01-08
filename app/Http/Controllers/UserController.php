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
}
