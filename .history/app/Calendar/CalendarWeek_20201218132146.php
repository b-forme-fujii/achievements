<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek {

	protected $carbon;
	protected $index = 0;

	function __construct($date, $index = 0){
		$this->carbon = new Carbon($date);
		$this->index = $index;
	}

	function getClassName(){
		return "week-" . $this->index;
	}

	/**
	 * @return CalendarWeekDay[]
	 */
	function getDays(){

		
	}
}