<?php
class HomePageStatisticCollector
{
	/*
	 * Author: Tomek Odrobny
	 * hook for count numbers of words added in last hour
	 */
	public static function articleCountWordDiff(&$article,&$user,&$newText){
		if (self::chackNamespace($article)){
			return true;
		}

		$diff = 0;
		$wNewCount = self::countWord($newText);
		$wOldCount = self::countWord($article->getRawText());
		$countDiff = $wNewCount - $wOldCount;

		if ($countDiff > 0){
			self::updateWordsInLastHour($countDiff);
		}

		return true;
	}
	/*
	 * Author: Tomek Odrobny
	 * count word in text
	 */
	private static function countWord($intext){
		$wordlength = 3;
		$wText = preg_split("/[\s]+/", $intext);
		$wCount = 0;
		foreach ($wText as $value){
			if (strlen($value) >= $wordlength ){
				$wCount++;
			}
		}
		return $wCount;
	}
	/*
	 * Author: Tomek Odrobny
	 * hook for numbers of new pages made in this month
	 */
	 
	public static function articleCountPagesAddedInLastHour(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){

		if (self::chackNamespace($article)){
			return true;
		}
		if ($status->value['new']){
			self::updatePagesAddedInLastHour(1);
		}
		return true;
	}

	/*
	 * Author: Tomek Odrobny
	 * hook for numbers of edits made in this week
	 */

	public static function articleCountUpdateEditsMadeWeek(&$article,&$user,&$newText){
		if (self::chackNamespace($article)){
			return true;
		}

		$aID = $article->getTitle()->getArticleID();
		if ($aID){
			self::updateEditsMadeWeek(1);
		}
		return true;
	}

	/*
	 * Author: Tomek Odrobny
	 * chack namespace
	 */
	private static function chackNamespace(&$article){
		global $wgContentNamespaces;
		return !in_array($article->getTitle()->getNamespace(),$wgContentNamespaces);
	}
	/*
	 * Author: Tomek Odrobny
	 * count and read numbers of new pages made in this month
	 */
	public static function updatePagesAddedInLastHour( $value = 0 ){
		$timeSample = 60;
		$fifoLength = 60*60; // one hour
		$key = wfSharedMemcKey( "hp_stats", "fifo_pages_added" );
		$out = self::fifoLine($value,$timeSample,$fifoLength,$key);
		return $out;
	}
	/*
	 * Author: Tomek Odrobny
	 * count and read numbers of edits made in this week
	 */
	public static function updateEditsMadeWeek( $value = 0 ){
		$timeSample = 60*60*7;
		$fifoLength = 60*60*8; // one minute
		$key = wfMemcKey( "hp_stats", "stat_hp_fifo_week" ); 
		$out = self::fifoLine($value,$timeSample,$fifoLength,$key);
		return $out;
	}

	/*
	 * Author: Tomek Odrobny
	 * add and read fifo value for words added in last hour
	 */
	public static function updateWordsInLastHour( $value = 0 ){
		$timeSample = 60;
		$fifoLength = 60*60; // one hour
		$key = wfSharedMemcKey( "hp_stats", "fifo_words" );
		$out = self::fifoLine($value,$timeSample,$fifoLength,$key);
		return $out;
	}
	/*
	 * Author: Tomek Odrobny
	 * hole value for same period example: this week,month
	 */
	private static function periodHolder( $period ,$key, $value = 0 ){
		$data = HomePageMemAdapter::getMemValue( $key );
		if($data == null){
			$data['period'] = time();
			$data['value'] = 0;
		}

		/* week change reset value */
		if($data['period'] != $period){
			$data['period'] = $period;
			$data['value'] = 0;
		}

		$data['value'] += $value;
		HomePageMemAdapter::setMemValue($key,$data);
		return $data['value'];
	}
	/*
	 * Author: Tomek Odrobny
	 * memory fifo line, tomek
	 */
	public static function fifoLine($value,$timeSample,$fifoLength,$key,$time = null){
		if ( $time == null ){
			$time = time();
		}
		
		$data = HomePageMemAdapter::getMemValue( $key );

		if($data == null){
			$data['timestamp'] = array($time);
			$data['fifo'] = array($value);
			HomePageMemAdapter::setMemValue($key,$data);
			return $value;
		}

		$newer = $data['timestamp'][count($data['timestamp'])-1];
		$timediff = $time - $newer;
		if ($value > 0){
			if ((($timediff - $timeSample) > 0) || ( count($data['fifo']) == 0)) {
				$data['fifo'][] =  $value;
				$data['timestamp'][] = time();
			} else {
				$data['fifo'][count($data['fifo'])-1] += $value;
			}
		}

		while ( (count($data['timestamp']) > 0) && (($time - $data['timestamp'][0]) > $fifoLength )){
			array_shift($data['fifo']);
			array_shift($data['timestamp']);
		}

		HomePageMemAdapter::setMemValue($key,$data);
		return array_sum($data['fifo']);
	}
}
