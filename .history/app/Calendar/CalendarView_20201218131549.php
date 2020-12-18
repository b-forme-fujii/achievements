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
		$weeks = [];

		//初日
		$firstDay = $this->carbon->copy()->firstOfMonth();

		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth();

		//1週目
		$week = new CalendarWeek($firstDay->copy());
		$weeks[] = $week;

		//月末までループさせる
		while($firstDay->lte($lastDay)){
			//週カレンダーViewを作成する
			$week = new CalendarWeek($firstDay, count($weeks));
			$weeks[] = $week;
			
            //次の週=+7日する
			$firstDay->addDay(7);
		}
		return $weeks;
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