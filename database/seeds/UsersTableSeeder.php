<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'school_id' => 2,
            'first_name' => '藤井',
            'last_name' => '俊祐',
            'full_name' => 'フジイシュンスケ',
            'age' => 29,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 1,
            'first_name' => '青木',
            'last_name' => '宣親',
            'full_name' => 'アオキノリチカ',
            'age' => 38,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 2,
            'first_name' => '金木',
            'last_name' => '研',
            'full_name' => 'カネキケン',
            'age' => 25,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 1,
            'first_name' => '中島',
            'last_name' => '直美',
            'full_name' => 'ナカシマナオミ',
            'age' => 24,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 2,
            'first_name' => '山田',
            'last_name' => '太郎',
            'full_name' => 'ヤマダタロウ',
            'age' => 18,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 2,
            'first_name' => '佐藤',
            'last_name' => '花子',
            'full_name' => 'サトウハナコ',
            'age' => 30,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 1,
            'first_name' => '真下',
            'last_name' => '幸子',
            'full_name' => 'マシタサチコ',
            'age' => 35,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 1,
            'first_name' => '橋本',
            'last_name' => '次郎',
            'full_name' => 'ハシモトジロウ',
            'age' => 23,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 2,
            'first_name' => '小橋',
            'last_name' => '照彦',
            'full_name' => 'コバシテルヒコ',
            'age' => 40,
        ];
        DB::table('users')->insert($param);

        $param = [
            'school_id' => 1,
            'first_name' => '渡部',
            'last_name' => '建',
            'full_name' => 'ワタベケン',
            'age' => 48,
        ];
        DB::table('users')->insert($param);
    }
}
