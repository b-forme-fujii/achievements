<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarView {

	private $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}
	/**
	 * タイトル
	 */
	public function getTitle(){
		return $this->carbon->format('Y年n月');
    }
    
    /**
     * 当月が何日あるかを取得
     */
    protected function getdays(){
		$days = [];
		//開始日〜終了日
		$startDay = $this->carbon->copy()->startOfWeek();
		$lastDay = $this->carbon->copy()->endOfWeek();

		//曜日の取得
		$weekday = ['日', '月', '火', '水', '木', '金', '土'];
		$weekday[Carbon::now()->dayOfWeek];

		//月曜日〜日曜日までループ
		while($startDay->lte($lastDay)){				
			//今月
			$day = new CalendarWeekDay($startDay->copy());	
			$days[] = $day;
		}
		return $days;
	}
}