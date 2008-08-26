<?php
#----
#
#
if ( !defined( 'MEDIAWIKI' ) ) 
{
	die();
}

require_once ("$IP/extensions/wikia/SpamRegexBatch/SpamRegexBatch.php");

class WikiaTitleBlackList
{
	var $spamList = null;
	var $settings = array();

	function __construct( $settings = array() ) 
	{
		global $wgDBname;
		
		foreach ( $settings as $name => $value ) 
		{
			$this->$name = $value;
		}
		
		$use_prefix = 0;

		if (empty($settings['regexes'])) 
			$settings['regexes'] = false;
		if (empty($settings['previousFilter'])) 
			$settings['previousFilter'] = false;
		if (empty($settings['files'])) 
			$settings['files'] = array("DB: wikicities MediaWiki:Blacklist_title_list");
		else
			$use_prefix = 1;	
		if (empty($settings['warningTime'])) 
			$settings['warningTime'] = 600;
		if (empty($settings['expiryTime'])) 
			$settings['expiryTime'] = 900;
		if (empty($settings['warningChance'])) 
			$settings['warningChance'] = 100;

		if (empty($settings['memcache_file'])) 
			$settings['memcache_file']  = 'blacklist_title_file'.(($use_prefix == 1) ? '_'.$wgDBname : "");
		if (empty($settings['memcache_regexes']))
			$settings['memcache_regexes'] = 'blacklist_title_regexes'.(($use_prefix == 1) ? '_'.$wgDBname : "");

		$this->settings = $settings;
	}

	public function getSettings()
	{
		return $this->settings;
	}

	function checkBlackListTitle(&$title, $text, $section) 
	{
		global $useSpamRegexNoHttp;
		#---
		$fname = 'checkBlackTitleList';
		wfProfileIn( $fname );
		#---
		$this->spamList = new SpamRegexBatch("titleblacklist", $this->settings);
		#---		
		$regexes = $this->spamList->getRegexes();
		$res = wfBlackListTitleParse(&$title, $regexes);

		if (!$res)
		{
			# Call the rest of the hook chain first
			if ( $this->spamList->getPreviousFilter() )
			{
				$f = $this->spamList->getPreviousFilter();
				if ( $f( $title, $text, $section ) ) 
				{
					wfProfileOut( $fname );
					return true;
				}
			}
		} 
	
		#---
		wfProfileIn( $fname );
		return $res;
	}
	
	public function getSpamList()
	{
		return $this->spamList;
	}
	
}

function wfBlackListTitleParse(&$title, $blacklist)
{
	#---
	$retVal = false;
	#---
	if (!($title instanceof Title)) {
	    return $retVal;
    }
    #---
	if (!empty($blacklist) && is_array($blacklist))
	{
		wfDebug( "Checking text against " . count( $blacklist ) . " regexes: " . implode( ', ', $blacklist ) . "\n" );
		foreach ($blacklist as $id => $regex) 
		{
			$m = array();
			if (preg_match($regex, strtolower($title->getText()), $m)) 
			{
				wfDebug( "Match!\n" );
				SpamRegexBatch::spamPage( $m[0], $title );
				$retVal = true;
				break;
			}
			if (preg_match($regex, strtolower($title->getFullText()), $m))
			{
					wfDebug( "Match!\n" );
					SpamRegexBatch::spamPage( $m[0], $title );
					$retVal = true;
					break;
			}
		}
	}
	
	return $retVal;
}

?>
