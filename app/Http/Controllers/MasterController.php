<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use App\Master;
use Illuminate\Support\Facades\DB;
use App\Exports\Export;
use App\Http\Requests\AchievementFormRequest;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\File;

class MasterController extends Controller
{
    /**
     * 実績閲覧ページ
     * 
     * @param Request $request
     * @return void
     * 本校と2校別で利用者情報を取得
     */
    public function master_index(Request $request)
    {
        //本校の利用者情報の取得
        $school_1 = new User();
        $school_1 = $school_1->School_1();

        //2校の利用者情報の取得
        $school_2 = new User();
        $school_2 = $school_2->School_2();

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
        ];
        return view('master.master_index', $data);
    }

    /**
     * 実績閲覧ページ
     * 
     * @param Request $request
     * @return void
     * 本校と2校別で利用者情報と選択された利用者の実績データを取得
     */
    public function check_records(Request $request)
    {
        $data = new Master();
        $data = $data->Records($request);

        return view('master.master_index', $data);
    }

    /**
     * 個別で実績データをダウンロード
     * 
     * @param Request $request
     * @return void
     * 
     */
    public function one_data(Request $request)
    {
        //テンプレートファイル取得
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./excel/sample.xlsx');

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('E1', '2021年');

        $writer = new Xlsx($spreadsheet);
        $writer->save('write.xlsx');
        return response()->download('write.xlsx');

        // //利用者の情報を取得
        // $user = new User();
        // $user = $user->getUser($request);

        //  //当月の日数を取得
        //  $days = new Achievement();
        //  $days = $days->One_Month($request);

        // //利用者の月の実績データの取得
        // $records = new Achievement();
        // $records = $records->Month_Records($request);

        // $data = [
        //     'user' => $user,
        //     'days' => $days,
        //     'records' => $records,
        // ];
    }
}
