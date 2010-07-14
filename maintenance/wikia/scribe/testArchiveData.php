<?php
/**
 * take old revisions and put events in events table via scribe
 * 
 *
 * @file
 * @ingroup Maintenance
 * @author Piotr Molski <moli@wikia-inc.com>
 */

ini_set('memory_limit', '-1');
ini_set('display_errors', 'stderr');
ini_set( "include_path", dirname(__FILE__)."/../.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
include_once("$IP/extensions/wikia/Scribe/ScribeClient.php");
include_once("$IP/extensions/wikia/Scribe/ScribeProducer.php");

# Do an initial scan for inactive accounts and report the result
echo( "Start script ...\n" );

$help = isset($options['help']);
$debug = isset($options['debug']);
$limit = isset($options['limit']) ? $options['limit'] : 100;

function time_duration($seconds, $use = null, $zeros = false) {
	$periods = array (
		'years'     => 31556926,
		'Months'    => 2629743,
		'weeks'     => 604800,
		'days'      => 86400,
		'hours'     => 3600,
		'minutes'   => 60,
		'seconds'   => 1
	);
	
	// Break into periods
	$seconds = (float) $seconds;
	$segments = array();
	foreach ($periods as $period => $value) {
		if ($use && strpos($use, $period[0]) === false) {
			continue;
		}
		$count = floor($seconds / $value);
		if ($count == 0 && !$zeros) {
			continue;
		}
		$segments[strtolower($period)] = $count;
		$seconds = $seconds % $value;
	}
	
	// Build the string
	$string = array();
	foreach ($segments as $key => $value) {
		$segment_name = substr($key, 0, -1);
		$segment = $value . ' ' . $segment_name;
		if ($value != 1) {
			$segment .= 's';
		}
		$string[] = $segment;
	}
	return implode(', ', $string);
}

function bytes($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function getEventsRecords($wikia = 0, $limit = 100) {
	global $wgStatsDB;
	$dbr = wfGetDB( DB_SLAVE, 'stats', $wgStatsDB );
	$where = array();
	
	if ( !empty($wikia) ) {
		$where = array('wiki_id' => $wikia);
	}
	
	$oRes = $dbr->select(
		array( "events" ),
		array( "*" ),
		$where,
		__METHOD__,
		array(
			'ORDER BY' => 'rand()',
			'LIMIT' => $limit
		)
	);

	$records = array();
	while( $oRow = $dbr->fetchObject( $oRes ) ) {
		$records[] = $oRow;
	}
	$dbr->freeResult( $oRes );
	
	return $records;
}

function _user_is_bot($user_text) {
	$user_is_bot = false;
	$oUser = User::newFromName($user_text);
	if ( $oUser instanceof User ) {
		$user_is_bot = $oUser->isBot();
	}
	return $user_is_bot ? 'Y' : 'N';
}

function _revision_is_redirect($content) {
	$titleObj = Title::newFromRedirect( $content );
	$rev_is_redirect = is_object($titleObj) ;
	return $rev_is_redirect ? 'Y' : 'N';
}

function _revision_is_content() {
	global $wgEnableBlogArticles, $wgTitle;
	
	$is_content_ns = 0;
	if ( $wgTitle instanceof Title ) {
		$is_content_ns = $wgTitle->isContentPage();
		if ( empty($is_content_ns) && $wgEnableBlogArticles ) { 
			$is_content_ns = (in_array($wgTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)));
		}
	}
	return $is_content_ns ? 'Y' : 'N';
}

function _make_links($page_id, $rev_id, $content) {
	$links = array(
		'image' => 0,
		'video' => 0			
	);
	$oArticle = Article::newFromId($page_id);
	if ( $oArticle instanceof Article ) {
		$editInfo = $oArticle->prepareTextForEdit( $content, $rev_id );
		$images = $editInfo->output->getImages();
		if ( !empty($images) ) {
			foreach ($images as $iname => $dummy) {
				if ( substr($iname, 0, 1) == ':' ) {
					$links['video']++;							
				} else {
					$links['image']++;
				}
			}
		}
	}
	return $links;
}

function loadFromDB($dbname, $page_id, $rev_id) {
	$db = wfGetDB( DB_SLAVE, 'stats', $dbname );

	$fields = Revision::selectPageFields();
	$fields = array_merge($fields, Revision::selectFields());
	$fields[] = " date_format(rev_timestamp, '%Y-%m-%d %H:%i:%s') as ts ";

	$oRow = $db->selectRow( 
		array('revision', 'page'), 
		$fields, 
		array( 
			"rev_page = page_id",
			'page_id' => $page_id,
			'rev_id' => $rev_id,
		),
		__METHOD__
	);

	if ( empty($oRow) ) {
		$fields = array(
			'ar_namespace as page_namespace',
			'ar_title as page_title',
			'ar_comment as rev_comment',
			'ar_user as rev_user',
			'ar_user_text as rev_user_text',
			'ar_timestamp as rev_timestamp',
			'ar_minor_edit as rev_minor_edit',
			'ar_rev_id as rev_id',
			'ar_text_id as rev_text_id',
			'ar_len as rev_len',
			'ar_page_id as page_id',
			'ar_page_id as rev_page',
			'ar_deleted as rev_deleted',
			'0 as rev_parent_id',
			'date_format(ar_timestamp, \'%Y-%m-%d %H:%i:%s\') as ts'
		);

		$conditions = array( 
			'ar_page_id'	=> $page_id , 
			'ar_rev_id'		=> $rev_id
		);

		$oRow = $db->selectRow( 
			'archive', 
			$fields, 
			$conditions,
			__METHOD__
		);
	}

	return $oRow;
}

function compareEventRecordWithRevision($dbname, $oRow, $debug) {
	global $wgTitle, $wgLanguageCode;

	$langcode = WikiFactory::getVarValueByName('wgLanguageCode', $oRow->wiki_id);
	$lang_id = WikiFactory::LangCodeToId($langcode);
	$cats = WikiFactory::getCategory($oRow->wiki_id);
	$cat_id = ( !emptY($cats) ) ? $cats->cat_id : 0;
	
	$result = false;
	if ( is_object($oRow) && !empty($oRow->page_id) && !empty($oRow->rev_id) ) {
		$data = loadFromDB($dbname, $oRow->page_id, $oRow->rev_id);
		if ( is_object($data) ) {
			$oRevision = new Revision($data);
			if ( $oRow->rev_id > 0 ) {
				$wgTitle = Title::makeTitle( $data->page_namespace, $data->page_title );
			} else {
				$wgTitle = $oRevision->getTitle();
			}
			$content = $oRevision->revText();
			$is_bot = _user_is_bot($data->rev_user_text);
			$is_content = _revision_is_content();
			$is_redirect = _revision_is_redirect($content);
			$size = intval($oRevision->getSize());
			$words = str_word_count( $content );
			$links = _make_links($oRow->page_id, $oRow->rev_id, $content);
			$timestamp = $data->ts;
			
			if ( 
				( $data->rev_page		== $oRow->page_id ) &&
				( $data->page_namespace	== $oRow->page_ns ) &&
				( $data->rev_id			== $oRow->rev_id  ) &&
				( $timestamp			== $oRow->rev_timestamp ) &&
				( $data->rev_user		== $oRow->user_id ) &&
				( $is_bot 				== $oRow->user_is_bot ) &&
				( $is_content			== $oRow->is_content ) &&
				( $is_redirect			== $oRow->is_redirect) &&
				( $size 				== $oRow->rev_size ) &&
				( $words 				== $oRow->total_words ) &&
				( $cat_id				== $oRow->wiki_cat_id ) &&
				( $lang_id				== $oRow->wiki_lang_id ) &&
				( $links['image']		== $oRow->image_links ) &&
				( $links['video']		== $oRow->video_links ) 
			) {
				$result = true;
			} else {
				if ( $debug ) {
					echo <<<TEXT
	page: {$data->rev_page} == {$oRow->page_id}
	namespage: {$data->page_namespace}	== {$oRow->page_ns}
	revision: {$data->rev_id}	== {$oRow->rev_id}
	timestamp: {$timestamp} == {$oRow->rev_timestamp}
	user: {$data->rev_user} == {$oRow->user_id}
	is_bot: {$is_bot} == {$oRow->user_is_bot}
	is_content: {$is_content} == {$oRow->is_content}
	is_redirect: {$is_redirect} == {$oRow->is_redirect}
	size: {$size} == {$oRow->rev_size}
	words: {$words} == {$oRow->total_words}
	category: {$cat_id} == {$oRow->wiki_cat_id}
	language: {$lang_id} == {$oRow->wiki_lang_id}
	image links:{$links['image']} == {$oRow->image_links}
	video links: {$links['video']} == {$oRow->video_links}

TEXT;
				}
			}
		} else {
			echo "Not local data found for: page: {$oRow->page_id} && revision: {$oRow->rev_id}  \n";
		}
	} else {
		echo "Not events data found for: page: {$oRow->page_id} && revision: {$oRow->rev_id}  \n";
	}
	
	return $result;
}

if ( $help ) {
	echo <<<TEXT
Usage:
    php testArchiveData.php --help
    php testArchiveData.php [--limit=N]

    --help         : This help message
    --limit=N      : Number of records to check
TEXT;
	exit(0);
}
else {
	$start = time();

	$wikia = $wgCityId;

	$records = getEventsRecords($wikia, $limit);
	$res = array(
		'ok' => 0,
		'error'	=> 0
	);
	echo "Found " . count($records) . " \n";
	foreach ( $records as $id => $oRow ) {
		$dbname = WikiFactory::IDtoDB($oRow->wiki_id);
		if ( $dbname ) {
			$result = compareEventRecordWithRevision($dbname, $oRow, $debug);
			$key = ( $result === false ) ? 'error' : 'ok';
			$res[$key]++;
		}
	}

	$end = time();
	echo "\n\nScript finished after: " . time_duration($end - $start) . " \n";
	echo "Result: ok:" . $res['ok'] . ", err:" . $res['error'] . " \n";
}

echo "end \n";
