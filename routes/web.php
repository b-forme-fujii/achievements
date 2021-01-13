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

/**当日の開始時間と登録日を実績テーブルに作成 */
Route::get('/new_record', 'AchievementController@new_record');

/**当日の終了時刻を登録 */
Route::get('/end_time', 'AchievementController@end_time');
/**ログイン必須ページ*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
