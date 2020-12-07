<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**ガードするフィールド */
    protected $guarded = array('id');

    /**
     * achievementsテーブルとusersテーブルをリレーション
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Achievement');
    }
}
