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
        //利用者の情報を取得
        $user = new User();
        $user = $user->getUser($request);

        //月初を取得
        $month = new Achievement();
        $month = $month->Beginning($request);

        //当月の日数を取得
        $days = new Master();
        $days = $days->Days($request);

        //当月の曜日を取得
        $weeks = new Master();
        $weeks = $weeks->Weeks($request);

        //利用者の月の実績データの取得
        // $records = new Master();
        // $records = $records->Month_Records($request);
        
        $records = new Master();
        $records = $records->Month_Records($request);
        // dd($records);   

        //テンプレートファイル取得
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./excel/sample.xlsx');

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $month->isoformat('Y'));
        $sheet->setCellValue('A2', $month->isoformat('M'));
        $sheet->setCellValue('A4', $user->first_name . $user->last_name);
        if ($user->school_id == 1) {
            $sheet->setCellValue('j4', "未来のかたち 本町本校");
        } else if ($user->school_id == 2) {
            $sheet->setCellValue('j4', "未来のかたち 本町第２校");
        }
        $sheet->fromArray($days, null, 'A9');
        $sheet->fromArray($weeks, null, 'B9');

        // $sheet->fromArray($records, null, 'C9');

        $offset = 9;
        foreach ($records as $i => $record) {
            $rowNum = $i + $offset;
            $sheet->setCellValueByColumnAndRow(3, $rowNum,$record);
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save('write.xlsx');
        return response()->download('write.xlsx');
    }
}
