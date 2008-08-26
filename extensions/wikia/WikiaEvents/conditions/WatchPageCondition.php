<?php

/**
 * @package MediaWiki
 * @subpackage Wikia Event's condition
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

/*
 * 
 * show message when page is updated
 * 
 */
class WatchPageCondition 
{
	#---
	const EVENT_KEY = 'watchpage';
	var $user = null;
	var $article = null;
	
	function __construct() 
	{
		// __CLASS__ contructor
	}

	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$edit_page) 
	{
		global $wgUser, $wgEnableSystemEvents;
		global $wgTitle;
		#---
		wfProfileIn( __METHOD__ );
		#---
		unset($result); 
		$result = true;

		#---
		if (empty($wgEnableSystemEvents) || empty($ev_id))
		{
			wfProfileOut( __METHOD__ );
			return true;
		}
		else
		{
			#---
			if ( class_exists('WikiaEventsConditions') ) 
			{
				$eventsCond = new WikiaEventsConditions($ev_id);
				#---
				if ($eventsCond)
				{
					# check event condition
					$isWatching = $wgTitle->userIsWatching();
					$articleNamespace = $wgTitle->getNamespace();
					$isContent = $wgTitle->getNamespace() == NS_MAIN || in_array( $articleNamespace, $wgContentNamespaces );
					
					if ( ($wgUser->isAnon()) && (!empty($_COOKIE['wgWikiaUniqueBrowserId'])) && ($isContent) )
					{
						wfDebug( "Execute WatchPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
						$eventsCond->executeCondition();
					}
					/*else
					{
						wfDebug( "Don't use WatchPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
						$eventsCond->switchOffMessage();
					}*/
				}
			} 
		}
		
		wfProfileOut( __METHOD__ );
		return $result;
	}
}

/*
 * for PHP < 5.2.x
 */

function wfWatchPageCondition($ev_id, &$edit_page)
{
	return WatchPageCondition::execute($ev_id, &$edit_page);
}

?>
