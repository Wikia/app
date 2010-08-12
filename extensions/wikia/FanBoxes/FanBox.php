<?php
//GLOBAL FANTAG NAMESPACE REFERENCE
if( !defined( 'NS_FANTAG' ) ) {
	define( 'NS_FANTAG', 600 );
}

$wgFanBoxPageDisplay['comments'] = true;

$wgHooks['TitleMoveComplete'][] = 'fnUpdateFanBoxTitle';
function fnUpdateFanBoxTitle(&$title, &$newtitle, &$user, $oldid, $newid) {
	if($title->getNamespace() == NS_FANTAG){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'fantag',
		array( 'fantag_title' => $newtitle->getText() ),
		array( 'fantag_pg_id' => $oldid ),
		__METHOD__ );
	}
	return true;
}

$wgHooks['ArticleDelete'][] = 'fnDeleteFanBox';
function fnDeleteFanBox(&$article, &$user, $reason) {
	global $wgTitle, $wgSupressPageTitle;
	if($wgTitle->getNamespace() == NS_FANTAG){
		$wgSupressPageTitle = true;
			
		$dbr =& wfGetDB( DB_MASTER );
		
		$s = $dbr->selectRow( '`fantag`',  array( 'fantag_pg_id', 'fantag_id' ), array( 'fantag_pg_id' => $article->getID() ), __METHOD__ );
		if ( $s !== false ) {
			
			//delete fanbox records
			$dbr->delete( 'user_fantag',
			array( 'userft_fantag_id' =>  $s->fantag_id ),
			__METHOD__ );
											
			$dbr->delete( 'fantag',
			array( 'fantag_pg_id' => $article->getID() ),
			__METHOD__ );
		}
		
	}
	return true;
}




$wgHooks['ArticleFromTitle'][] = 'wfFantagFromTitle';
$wgHooks['ParserBeforeStrip'][] = 'fnFanBoxTag';

$wgExtensionFunctions[] = 'wfFanBox';


//ParserBeforeStrip
//Convert [[Fan:Fan_Name]] tags to <fan></fan> hook
function fnFanBoxTag(&$parser, &$text, &$strip_state) {
	global $wgContLang;
	$fantitle = $wgContLang->getNsText( NS_FANTAG );
	$pattern = "@(\[\[$fantitle)([^\]]*?)].*?\]@si";
        $text = preg_replace_callback($pattern, 'wfRenderFanBoxTag', $text);
	
        return true;	
}


//on preg_replace_callback
//found a match of [[Fan:]], so get parameters and construct <fan> hook
function wfRenderFanBoxTag($matches){
	global $wgOut, $IP;
	
	$name = $matches[2];
	$params = explode("|",$name);
	$fan_name = $params[0];
	$fan_name = Title::newFromDBKey($fan_name);
	
	if( ! is_object($fan_name) ) return "";
	
	$fan =  FanBox::newFromName( $fan_name->getText() );

	if( $fan->exists() ){	
		$output = "<fan name=\"{$fan->getName()}\"></fan>";
		return $output;
	}
	return $matches[0];
	
}



//ArticleFromTitle
//Calls BlogPage instead of standard article
function wfFantagFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgMessageCache, $wgStyleVersion, $wgSupressPageTitle, 
	$wgSupressPageCategories, $wgFanBoxDirectory, $wgFanBoxScripts;
	
	if ( NS_FANTAG == $title->getNamespace()  ) {
		$wgSupressPageTitle = true;
		
		require_once ( "FanBox.i18n.php" );
		foreach( efWikiaFantag() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
	
		require_once( "{$wgFanBoxDirectory}/FanBoxPage.php" );
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css?{$wgStyleVersion}\"/>\n");
				
		
		if( $wgRequest->getVal("action") == "edit" ){
			$add_title = Title::makeTitle(NS_SPECIAL,"UserBoxes");
			$fan = FanBox::newFromName( $title->getText() );
			if(!$fan->exists()){
				$wgOut->redirect( $add_title->getFullURL() . "&destName=" . $fan->getName() );
			}
			else{
				$update = Title::makeTitle( NS_SPECIAL, "UserBoxes");
				$wgOut->redirect( $update->getFullURL("id=".$wgTitle->getArticleID() ) );
			}
		}

		//$wgSupressPageCategories = true;
		$article = new FanBoxPage($wgTitle);
		
	}

	return true;
}

//wgExtensionFunctions
//new <video> hook
function wfFanBox() {
	global $wgParser;
	$wgParser->setHook('fan', 'wfFanBoxEmbed');
}

function wfFanBoxEmbed($input, $argv, &$parser){
	global $wgOut, $wgRequest, $wgMessageCache, $IP, $wgUser, $wgFanBoxScripts;

	$parser->disableCache();
	
	if( strpos( $wgOut->mScripts, "{$wgFanBoxScripts}/FanBoxes.css" ) === false ){
		//$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css\"/>\n");
	}
	
	if( strpos( $wgOut->mScripts, "{$wgFanBoxScripts}/FanBoxes.js" ) === false ){
		//$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js\"></script>\n");
	}

	global $wgHooks;
	$wgHooks["GetHTMLAfterBody"][] = "wfAddFanBoxScripts";
		
	require_once ( "FanBox.i18n.php" );
		foreach( efWikiaFantag() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
	
	$fan_name = $argv["name"];
	if(!$fan_name){
		return "";
	}
	
	$fan =  FanBox::newFromName($fan_name );

	if( $fan->exists() ){

		$output .= $fan->outputFanBox();
		$fantag_id = $fan->getFanBoxId();

		$output .= "<div id=\"show-message-container".$fantag_id."\">";
		if($wgUser->isLoggedIn()){
			$check = $fan->checkIfUserHasFanBox();
			if ($check == 0){
				$output .= $fan->outputIfUserDoesntHaveFanBox();

			}
			else $output .= $fan->outputIfUserHasFanBox();
		}
		else {
			$output .= $fan->outputIfUserNotLoggedIn();
		}

		
		$output .= "</div>";

	}
	return $output;
		
}

function wfAddFanBoxScripts(&$tpl){
	global $wgOut, $wgFanBoxScripts, $wgStyleVersion, $wgStylePath;

	if( $tpl->data['fanbox-scripts-loaded'] != 1 ){
		echo ("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css?{$wgStyleVersion}\"/>\n");
		echo ("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.js?{$wgStyleVersion}\"/>\n");
		
		$tpl->set( 'fanbox-scripts-loaded', 1 );
	}
	return true;
}

$wgHooks['UserRename::Local'][] = "FantagUserRenameLocal";

function FantagUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'fantag',
		'userid_column' => 'fantag_user_id',
		'username_column' => 'fantag_user_name',
	);
	$tasks[] = array(
		'table' => 'user_fantag',
		'userid_column' => 'userft_user_id',
		'username_column' => 'userft_user_name',
	);
	return true;
}

?>
