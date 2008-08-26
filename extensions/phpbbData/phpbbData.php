<?php
/** \file
* \brief Contains code for the phpbbData Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "phpbbData extension";
	exit(1);
}

$wgPhpbbDataRootPath        = 'forum/';	
$wgPhpbbDataUpdatedDuration = 24;		# hours

$wgExtensionCredits['other'][] = array(
	'name'        => 'phpbbData',
	'version'     => '1.0',
	'author'      => 'Tim Laqua',
	'description' => 'Allows you to include phpBB data in wiki pages',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:phpbbData',
);

$wgExtensionFunctions[] = 'efPhpbbData_Setup';
$wgHooks['LanguageGetMagic' ][] = 'efPhpbbData_LanguageGetMagic';
$wgHooks['BeforePageDisplay'][] = 'efPhpbbData_BeforePageDisplay';

function efPhpbbData_Setup() {
        global $wgParser, $wgMessageCache;
	
		#Add Messages
		require( dirname( __FILE__ ) . '/phpbbData.i18n.php' );
		foreach( $messages as $key => $value ) {
			  $wgMessageCache->addMessages( $messages[$key], $key );
		}
		
        # Set a function hook associating the "example" magic word with our function
        $wgParser->setFunctionHook( 'phpbb', 'efPhpbbData_RenderList' );
        $wgParser->setFunctionHook( 'phpbblink', 'efPhpbbData_RenderLink' );
		
		return true;
}

function efPhpbbData_BeforePageDisplay(&$out) { 
	global $wgRequest;
	
	# Check for toForum query string argument
	if ($wgRequest->getText('toForum')) {
		# Make a link that returns to the forum page the user
		# just came from
		$link = '<div style="float: right;"><a href="' . 
			htmlspecialchars($wgRequest->getText('toForum')) . 
			'">&rarr; Return to Forum</a></div>' . $text;
		
		# Add the Return to Forum link in to the page title
		# Since we're making it render HTML in a second,
		# encode special characters in the old page title
		$out->mPagetitle = $link . htmlspecialchars($out->getPageTitle());
		
		# Content of mPageLinkTitle doesn't actually get displayed 
		# When there is a value in mPageLinkTitle, the template 
		# forces HTML rather than Text rendering of $out->mPagetitle
		$out->mPageLinkTitle = $out->mPagetitle;
	}
	
	# Be nice.
	return true;
}

function efPhpbbData_LanguageGetMagic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitive, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['phpbb'] = array( 0, 'phpbb' );
        $magicWords['phpbblink'] = array( 0, 'phpbblink' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

function efPhpbbData_makeTopicWikiLink($display_text='', $forum_id=null, $topic_id=null, $post_id=null) {
	global $wgPhpbbDataRootPath, $wgTitle, $wgServer;

	if (!empty($post_id)) {
		$urlText = "{$wgServer}/{$wgPhpbbDataRootPath}viewpost.php?p={$post_id}&toWiki=" . 
			urlencode($wgTitle->escapeLocalURL());
	} elseif (!empty($topic_id)) {
		$urlText = "{$wgServer}/{$wgPhpbbDataRootPath}viewtopic.php?t={$topic_id}&toWiki=" . 
			urlencode($wgTitle->escapeLocalURL());
	} elseif (!empty($forum_id)) {
		$urlText = "{$wgServer}/{$wgPhpbbDataRootPath}viewforum.php?t={$forum_id}&toWiki=" . 
			urlencode($wgTitle->escapeLocalURL());
	}
	
	if ($display_text != '')
		$display_text = ' ' . $display_text;
	else
		$display_text = ' ' . $urlText;
	
	return "<span class='plainlinks'>[{$urlText}{$display_text}]</span>";
}

function efPhpbbData_RenderLink( &$parser, $linktype, $id, $text='', $options = 'none') {
	
	switch ($linktype) {
		case 'topic':
			if ( isset($id) ) {
				$id = intval($id);
				$text = htmlspecialchars($text);
				
				return efPhpbbData_makeTopicWikiLink($text, null, $id);
			} else {
				return "Bad ID";
			}
			break;
		default:
			return "Unknown link type: " .  $linktype;
			break;
	}
	
}

function efPhpbbData_RenderList( &$parser, $action = 'announcements', $forum_id = 0, 
	$template = "* '''TOPIC_TIME:''' TOPIC_TITLE",$options = 'none') {
	
	global $wgPhpbbDataUpdatedDuration;
	
	$dateFields = array('topic_time','topic_last_post_time');
	$opts = explode(',', $options);
	
	$parser->disableCache();
	
	switch ($action) {
		case 'announcements':
			global $wgPhpbbDataRootPath, $wgPhpbbData, $wgContLang;
			
			if (!isset($wgPhpbbData))
				$wgPhpbbData = new phpbbDataProvider($_SERVER['DOCUMENT_ROOT'] . '/' . $wgPhpbbDataRootPath);
			
			if ($announcements = $wgPhpbbData->getAnnouncements($forum_id)) {
				foreach ($announcements as $announcement) {
					$rowString = $template;
					foreach($announcement as $key => $value) {
						if (in_array($key,$dateFields)) {
							if ( strtoupper($key) == 'TOPIC_LAST_POST_TIME' && $wgPhpbbDataUpdatedDuration > intval( (wfTimestamp( TS_UNIX, time() ) - wfTimestamp(TS_UNIX, $value)) / 60 / 60 ) )
								$rowString = str_replace(strtoupper($key),'<span style="color: #ff0000; font-weight: bold; text-decoration: blink;">' . $wgContLang->timeanddate($value, true) . '</span>', $rowString );
							else
								$rowString = str_replace(strtoupper($key),$wgContLang->timeanddate($value, true),$rowString);
							
						} else {
							if (strtoupper($key) == 'TOPIC_TITLE' && in_array('nolinks',$opts))
								$rowString = str_replace(strtoupper($key),$value,$rowString);
							else
								$rowString = str_replace(strtoupper($key),efPhpbbData_makeTopicWikiLink($value, $announcement['fid'],$announcement['tid']),$rowString);
						}
					}
					$returnString .= $rowString . "\n";
				}
				return $returnString;
			} else {
				if (in_array('hideempty',$opts)) 
					return '<div style="display: none;"></div>';
				else
					return "No Announcements\n";
			}
			break;
		default:
			return "Unknown action: " . $action;
			break;
	}
}

class phpbbDataProvider {
	var $mDB = '';
	var $mRootPath = '';
	var $mPhpEx = '';
	var $mTablePrefix = '';
	
	function __construct($phpbb_root_path) {
		define('IN_PHPBB', true);
		$this->mRootPath = $phpbb_root_path;
		$this->mPhpEx = substr(strrchr(__FILE__, '.'), 1);
		
		$this->connect();
	}
	
	private function connect() {
		$phpEx = $this->mPhpEx;
		$phpbb_root_path = $this->mRootPath;
		
		include($phpbb_root_path . 'config.' . $phpEx);
		include($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);

		$this->mTablePrefix = $table_prefix;
		
		$this->mDB = new $sql_db();
		$this->mDB->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, false);

		// We do not need this any longer, unset for safety purposes
		unset($dbpasswd);
		
		return true;
	}
	
	public function getAnnouncements($forum_id) {
		$phpEx = $this->mPhpEx;
		$phpbb_root_path = $this->mRootPath;
		
		$topicstable = $this->tableName('topics');
		$forumstable = $this->tableName('forums');
		$iconstable = $this->tableName('icons');
		$poststable = $this->tableName('posts');
		
		$forumclause = "$topicstable.forum_id=" . intval($forum_id);
		
		$sql = 
			"SELECT DISTINCT $topicstable.topic_id as tid, $topicstable.forum_id as fid, topic_time, topic_title, topic_first_poster_name, topic_replies, topic_last_post_time, post_text " .
			"FROM $topicstable LEFT JOIN $forumstable USING (forum_id) LEFT JOIN $poststable ON (topic_first_post_id=post_id) " .
			"WHERE $forumclause " .
			"AND topic_type IN (2,3) " . 
			"ORDER BY topic_time DESC";
		$result = $this->mDB->sql_query( $sql );
		if ($result) {
			while ($row = $this->mDB->sql_fetchrow($result)) {
				$rowArray[] = $row;
			}
			
			return $rowArray;
		} else {
			return false;
		}
	}
	
	public function tableName($table) {
		return $this->mTablePrefix . $table;
	}
}
