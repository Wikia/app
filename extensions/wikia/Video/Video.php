<?php
/**
 * Wiki Video Namespace
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Pean <david.pean@gmail.com> - original code/ideas
 * @copyright Copyright (C) 2007 David Pean, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Video',
	'description' => 'Allows new Video namespace for embedable media on supported sites.',
	'author' => 'David Pean'
);

$wgHooks['ArticleFromTitle'][] = 'wfVideoFromTitle';
$wgHooks['CategoryPageView'][] = 'wfCategoryPageWithVideo';
$wgHooks['ParserBeforeStrip'][] = 'fnVideoTag';

// read file with languages
$wgExtensionFunctions[] = 'wfVideoReadLang';
$wgExtensionFunctions[] = 'wfVideo';
$wgLogTypes[]           = 'video';
$wgLogNames['video']            = 'videologpage';
$wgLogHeaders['video']          = 'videologpagetext';
$wgLogActions['video/video'] = 'videologentry';
	
//ParserBeforeStrip
//Convert [[Video:Video_Name]] tags to <video></video> hook
function fnVideoTag(&$parser, &$text, &$strip_state) {
	$pattern = "@(\[\[Video:)([^\]]*?)].*?\]@si";
        $text = preg_replace_callback($pattern, 'wfRenderVideo', $text);
	
        return true;	
}

//on preg_replace_callback
//found a match of [[Video:]], so get parameters and construct <video> hook
function wfRenderVideo($matches){
	global $wgOut, $IP;
	require_once( "$IP/extensions/wikia/Video/VideoClass.php" );
	
	$name = $matches[2];
	$params = explode("|",$name);
	$video_name = $params[0];
	$video =  Video::newFromName( $video_name );
	$x = 1;
	
	foreach($params as $param){
		if($x > 1){
			$width_check = preg_match("/px/i", $param );
			
			if($width_check){
				$width = preg_replace("/px/i", "", $param);
			}else{
				$align = $param;
			}
		}
		$x++;
	}
	if ( is_object( $video ) ) {
		if( $video->exists() ){	
			$output = "<video name=\"{$video->getName()}\" width=\"{$width}\" align=\"{$align}\"></video>";
			return $output;
		}
	}
	return $matches[0];
	
}

//read in localisation messages
function wfVideoReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "$IP/extensions/wikia/Video/Video.i18n.php" );
	foreach( efWikiaVideo() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

//ArticleFromTitle
//Calls VideoPage instead of standard article
function wfVideoFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut;
	
	require_once( "$IP/extensions/wikia/Video/VideoClass.php" );
	require_once( "$IP/extensions/wikia/Video/VideoPage.php" );
	if ( NS_VIDEO == $title->getNamespace()  ) {
		
		if( $wgRequest->getVal("action") == "edit" ){
			$add_title = Title::makeTitle(NS_SPECIAL,"AddVideo");
			$video = Video::newFromName( $title->getText() );
			if(!$video->exists()){
				$wgOut->redirect( $add_title->escapeFullURL("destName=".$video->getName()));
			}
		}
		$article = new VideoPage(&$title);
	}

	return true;
}

//wgExtensionFunctions
//new <video> hook
function wfVideo() {
	global $wgParser;
	$wgParser->setHook('video', 'wfVideoEmbed');
}

function wfVideoEmbed($input, $argv, &$parser){
	
	$video_name = $argv["name"];
	if(!$video_name){
		return "";
	}
	
	$width  = $width_max  = 425;
	$height = $height_max = 350;
	$valid_align = array("LEFT","CENTER","RIGHT");
	
	if (!empty($argv['width']) && ($width_max >= $argv['width'])){
		$width = $argv['width'];
	}
	if (!empty($argv['height']) && ($height_max >= $argv['height'])){
		$height = $argv['height'];
	}
	$align = $argv['align'];
	if ( in_array( strtoupper($align), $valid_align) ){
		$align_tag = " class=\"float{$align}\" ";
	}
	global $IP;
	require_once( "$IP/extensions/wikia/Video/VideoClass.php" );
	$video =  Video::newFromName($video_name );
	if( $video->exists() ){
		$video->setWidth($width);
		$video->setHeight($height);
		
		$output .= "<div {$align_tag}>";
		$output .= $video->getEmbedCode();
		$output .= "</div>";
	}
	return $output;
		
}

//CategoryPageView
//injects Video Gallery into Category pages
function wfCategoryPageWithVideo(&$cat){
	global  $wgOut;
	
	$article = new Article($cat->mTitle);
	$article->view();
	
	if ( NS_CATEGORY == $cat->mTitle->getNamespace() ) {
		global $wgOut, $wgRequest;
		$from = $wgRequest->getVal( 'from' );

		$viewer = new CategoryWithVideoViewer( $cat->mTitle, $from, $until);
		$wgOut->addHTML( $viewer->getHTML() );
	}
 
	return false;
}

$wgHooks['UserRename::Local'][] = "VideoUserRenameLocal";

function VideoUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'video',
		'userid_column' => 'video_user_id',
		'username_column' => 'video_user_name',
	);
	$tasks[] = array(
		'table' => 'oldvideo',
		'userid_column' => 'ov_user_id',
		'username_column' => 'ov_user_name',
	);
	return true;
}

?>
