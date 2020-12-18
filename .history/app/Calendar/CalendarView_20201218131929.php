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
     * 当月が何週間あるかを取得
     */
    protected function getWeeks(){
		$days = [];

		//開始日〜終了日
		$startDay = $this->carbon->copy()->startOfWeek();
		$lastDay = $this->carbon->copy()->endOfWeek();

		//月曜日〜日曜日までループ
		while($startDay->lte($lastDay)){				
			//今月
			$day = new CalendarWeekDay($startDay->copy());	
			$days[] = $day;
		}
		
		return $days;
	}

	/**
	 * カレンダーを出力する
	 */
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th>土</th>';
		$html[] = '<th>日</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';
		
		$html[] = '<tbody>';
		
        $weeks = $this->getWeeks();
        foreach($weeks as $week){
            			$html[] = '<tr class="'.$week->getClassName().'">';
            			$days = $week->getDays();
            			foreach($days as $day){
            				$html[] = '<td class="'.$day->getClassName().'">';
            				$html[] = $day->render();
            				$html[] = '</td>';
            			}
            			$html[] = '</tr>';
            		}
            		
            		$html[] = '</tbody>';
            
                    $html[] = '</table>';
                    $html[] = '</div>';

		return implode("", $html);
	}
}