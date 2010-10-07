<?php
$wgExtensionFunctions[] = 'wfCommonReadLang';

$wgHooks['BeforePageDisplay'][] = 'wfSocialToolsLoadJs';

function wfSocialToolsLoadJs() {
	wfProfileIn(__METHOD__);
	global $wgOut, $wgStyleVersion, $wgExtensionsPath, $wgUseOneJsToRule;

	if (!empty($wgUseOneJsToRule)) {
		// macbre: RT #69793
		$StaticChute = new StaticChute('js');
		$StaticChute->useLocalChuteUrl();
		$yuiPackageURL = $StaticChute->getChuteUrlForPackage('yui');

		$wgOut->addScript('<script type="text/javascript" src="' . $yuiPackageURL . '"></script>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/onejstorule.js?' . $wgStyleVersion . '"></script>');
	}

	wfProfileOut(__METHOD__);
	return true;
}

//read in localisation messages
function wfCommonReadLang(){
	global $wgMessageCache, $IP, $wgVoteDirectory;
	require_once ( "CommonNY.i18n.php" );
	foreach( efWikiaCommon() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

function getValue(&$pagename,&$input,$name){
	if(preg_match("/^\s*$name\s*=\s*(.*)/mi",$input,$matches)) {
		$pagename=htmlspecialchars($matches[1]);
	}
}

$max_link_text_length = 20;
function cut_link_text($matches){
	global $max_link_text_length;

	$tag_open = $matches[1];
	$link_text = $matches[2];
	$tag_close = $matches[3];

	$image = preg_match("/<img src=/i", $link_text );
	$is_url = ereg("^(http|https|ftp)://(www\.)?.*$", $link_text );

	//$max_link_text_length = 50;
	if( $is_url && !$image && strlen($link_text ) > $max_link_text_length){
		$start = substr($link_text,0,($max_link_text_length/2)-3 );
		$end = substr($link_text,strlen($link_text ) - ($max_link_text_length/2) +3,($max_link_text_length/2)-3);
		$link_text = trim($start) . "..." . trim($end);
	}
	return $tag_open . $link_text . $tag_close;
}

function get_dates_from_elapsed_days($number_of_days){
	$dates[date("F j, Y", time() )] = 1; //gets today's date string
	for($x=1;$x<=$number_of_days;$x++){
		$time_ago = time() - (60 * 60 * 24 * $x);
		$date_string = date("F j, Y", $time_ago);
		$dates[$date_string] = 1;
	}
	return $dates;
}

function date_diff_ny($dt1, $dt2) {

	$date1 = $dt1; //(strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
	$date2 = $dt2; //(strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;

	$dtDiff = $date1 - $date2;

	$totalDays = intval($dtDiff/(24*60*60));
	$totalSecs = $dtDiff-($totalDays*24*60*60);
	$dif['w'] = intval($totalDays/7);
	$dif['d'] = $totalDays;
	$dif['h'] = $h = intval($totalSecs/(60*60));
	$dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
	$dif['s'] = $totalSecs-($h*60*60)-($m*60);

	return $dif;
}

function get_time_offset($time,$timeabrv,$timename){
	if($time[$timeabrv]>0){
		$timeStr = wfMsgExt( "time_{$timename}", "parsemag", $time[$timeabrv] ) . ' ';
		return $timeStr;
	}
	else {
		return '';
	}
}

function get_time_ago($time){
	$timeArray =  date_diff_ny(time(),$time  );
	$timeStr = "";
	$timeStrD = get_time_offset($timeArray,"d","days");
	$timeStrH = get_time_offset($timeArray,"h","hours");
	$timeStrM = get_time_offset($timeArray,"m","minutes");
	$timeStrS = get_time_offset($timeArray,"s","seconds");
	$timeStr = $timeStrD;
	if($timeStr<2){
		$timeStr.=$timeStrH;
		$timeStr.=$timeStrM;
		if(!$timeStr)$timeStr.=$timeStrS;
	}
	if(!$timeStr)$timeStr = wfMsgExt( "time_seconds", "parsemag", 1);
	return $timeStr;
}


function shorten_text( $text, $chars=25 ) {
	if( strlen( $text ) <= $chars )
		return $text;

	$text = $text . " ";
	$text = substr( $text, 0, $chars );
	if( strrpos( $text, ' ') || strrpos( $text, '/' ) ){
	    $text = substr( $text, 0, max( strrpos( $text, ' '), strrpos( $text, '/' ) ) );
	}

	$text = $text . "...";

	return $text;
}

//called from $wgHooks["SkinTemplateOutputPageBeforeExec"]
function wfSuppressCategoryLinks( $skin, $tpl ){
	$tpl->set( 'catlinks', "" );

	return true;
}

?>
