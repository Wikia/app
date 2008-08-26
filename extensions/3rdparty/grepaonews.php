<?php
################################################################################
# <aonews><li><a href="!!URL!!" target="_blank">!!DATE!! - !!TITLE!!</a></li>|4</aonews>
################################################################################

################################################################################
# Mediawiki Hook
################################################################################

if( !defined( 'MEDIAWIKI' ) ) die();
$wgExtensionFunctions[] = 'setupgrepaonews';

################################################################################
# Class
################################################################################
class aonews {
	
	function cache($data) {
		$data = serialize($data);
		$fp = fopen("./extensions/aonews_cache.txt","w");
		fputs ($fp,$data);
		fclose ($fp);
	}
	
	function run($url) {
		if(!$data = $this->getdata($url)) return false;
		$data = $this->parsedata($data,$url);
		return $data;
	}
	
	function reorder_pregmatchall($data,$sort) {
		unset($data[0]);
		foreach ($data as $okey  => $o) {
			foreach ($o as $ikey => $i) {
				$output[$ikey][$sort[$okey-1]] = $i;
			}
		}
		return $output;
	}

	function getdata($url) {
		$timeToEnd = time()+5;
		while (!($connection = @fopen($url, "r")) && (time() < $timeToEnd));
		if (!$connection) return '-1';
		while (!feof ($connection)) { $data .= fgets($connection,10000); }
		fclose($connection);
		return $data;
	}	
	
	function parsedata($data,$url) {
		#---- fetch main data ----#
		preg_match('/<!-- RIGHTBAR BEGIN -->(.*)<!-- RIGHTBAR END -->/is',$data,$out);
		$data = $out[0];

		#---- featch single news values ----#		
		preg_match_all('/<p class="date">(.*?)<\/p>(?:.+?)<p><a href="(.*?)">(.*?)<\/a><\/p>/is',$data,$out);
		
		#---- add basic url to single values ----#
		$sort = $out[1];
		foreach($out[2] as $k => $v) {
			$out[2][$k] = $url.$v;
		}
		
		#---- resort array to a more logic array ----#
		$sort = array('date','url','title');
		$output = $this->reorder_pregmatchall($out,$sort);
		return $output;
	}
}

################################################################################
# Functions
################################################################################

function setupgrepaonews() {
  global $wgParser;
  $wgParser->setHook( 'aonews', 'aonewshandler' );
}

function aonewshandler($data) {
	#--- Config ----#
	$data = explode('|',$data);
	$template = $data[0];
	$shownumnews = $data[1];
	$url = "http://anarchy-online.com/content/news";

	#--- Run ----#
	$aonews = new aonews();
	$news = $aonews->run($url);
	
	
	$maxnum = count($news);
	if ($shownumnews > 0 && $shownumnews-1 < $maxnum) $maxnum = $shownumnews;
	
	for($i=0;$i<$maxnum;$i++) {
		$n = $news[$i];
		$cn = $template;
		$cn = str_replace('!!DATE!!',$n['date'],$cn);
		$cn = str_replace('!!TITLE!!',$n['title'],$cn);
		$cn = str_replace('!!URL!!',$n['url'],$cn);
		$output .= $cn;		
	}
	return $output;
}






?>
