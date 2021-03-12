<?php

namespace App\Http\Controllers;

use App\User;
use App\Achievement;
use App\Master;
use Carbon\Carbon;
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

        $bmonth = Carbon::now()->firstOfMonth();

        $data = [
            'school_1' => $school_1,
            'school_2' => $school_2,
            'bmonth' => $bmonth,
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
        $date = new Carbon($request->month);
        $date = $date->isoFormat('Y-M.');
        //利用者の情報を取得
        $user = new User();
        $user = $user->getUser($request);

        $name = $date . $user->first_name . $user->last_name . '.xlsx';

        //月初を取得
        $month = new Carbon($request->month);

        //当月の日数を取得
        $days = new Master();
        $days = $days->Excel_Days($request);

        //一ヶ月分の実績データを取得
        $records = new Master();
        $records = $records->Month_Records($request);

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

        $offset = 9;
        foreach ($records as $i => $record) {
            $rowNum = $i + $offset;
            if (
                array_key_exists('insert_date', $record) and
                array_key_exists('start_time', $record) and
                array_key_exists('end_time', $record) and
                array_key_exists('food', $record) and
                array_key_exists('outside_support', $record) and
                array_key_exists('medical_support', $record) and
                array_key_exists('note', $record)
            ) {
                $sheet->setCellValueByColumnAndRow(3, $rowNum, "");
                $sheet->setCellValueByColumnAndRow(4, $rowNum, $record['start_time']);
                $sheet->setCellValueByColumnAndRow(5, $rowNum, $record['end_time']);
                $sheet->setCellValueByColumnAndRow(7, $rowNum, $record['food']);
                $sheet->setCellValueByColumnAndRow(8, $rowNum, $record['outside_support']);
                $sheet->setCellValueByColumnAndRow(9, $rowNum, $record['medical_support']);
                $sheet->setCellValueByColumnAndRow(10, $rowNum, $record['note']);
            }
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save($name);
        return response()->download($name);
    }

    public function dl_school1(Request $request)
    {

        //本校の利用者情報の取得
        $user = new User();
        $user = $user->ExcleSchool_1();

        $months = new Master();
        $months = $months->Exele_Months();

        $data = [
            'user' => $user,
            'months' => $months,
        ];

        return view('master.dl_excel', $data);
    }

    public function dl_school2(Request $request)
    {

        //本校の利用者情報の取得
        $user = new User();
        $user = $user->ExcleSchool_2();

        $months = new Master();
        $months = $months->Exele_Months();

        $data = [
            'user' => $user,
            'months' => $months,
        ];
        return view('master.dl_excel', $data);
    }

    public function bulk_creation(Request $request)
    {
        $bmonth = new Carbon($request->month);

        //当月の日数を取得
        $days = new Master();
        $days = $days->Excel_Days($request);
 
        $school_id = $request->school_id;
        $users = User::where('school_id',$school_id)
        ->get();

        //利用者の一ヶ月間のレコードを取得
        foreach ($users as $user) {
            $achievements = Achievement::where('user_id',$user->id)
            ->whereYear('insert_date', $bmonth)
            ->whereMonth('insert_date', $bmonth)
            ->orderBy('insert_date', 'asc')
            ->get();
            dd($achievements);
        }
        
    }
}
