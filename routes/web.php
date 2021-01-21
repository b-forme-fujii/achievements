<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('hello', 'HelloController@index');

/**ユーザー選択ページ*/
Route::get('/', 'UserController@index');

/**実績登録ページ*/
Route::get('/achievement', 'AchievementController@selection');

/**実績テーブルにレコードを新規作成 */
Route::get('/new_record', 'AchievementController@new_record');

/**終了時刻を登録 */
Route::get('/end_time', 'AchievementController@end_time');

/**食事提供加算を更新*/
Route::get('/food_up', 'AchievementController@food_up');

/**施設外支援を更新*/
Route::get('/outside_up', 'AchievementController@outside_up');

/**医療連携体制加算を更新*/
Route::get('/medical_up', 'AchievementController@medical_up');

/**備考を更新*/
Route::get('/note_up', 'AchievementController@note_up');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/** ログイン必須ページ*/
//利用者情報のみ取得
Route::get('/master', 'MasterController@master_index')->middleware('auth');
//利用者と該当利用者の実績データを取得
Route::get('/check_recodes', 'MasterController@get_recodes')->middleware('auth');
//新規利用者登録ページへ移動
Route::get('/new_user', 'UserController@add_user')->middleware('auth');
//新規利用者の登録登録
Route::post('/create_user', 'UserController@create_user')->middleware('auth');

