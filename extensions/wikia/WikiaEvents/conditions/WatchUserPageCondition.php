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
 * Discuss article for visitors
 * 
 */
class WatchUserPageCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags) 
	{
		global $wgEnableSystemEvents, $wgContentNamespaces;
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
					#--- basic condition
					$articleID = $article->getTitle()->getArticleID();
					$isProtected = $article->getTitle()->isProtected();
					if ( $articleID && (!$isProtected) ) 
					{
						#--- user didn't edit that page ...
						$isWatching = $article->getTitle()->userIsWatching();
						$articleNamespace = $article->getTitle()->getNamespace();
						$isContent = $article->getTitle()->getNamespace() == NS_MAIN || in_array( $articleNamespace, $wgContentNamespaces );
						#---
						if ( ($user->isLoggedIn()) && (empty($isWatching)) && ($isContent) )
						{
							wfDebug( "Execute WatchUserPageCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
							$eventsCond->executeCondition();
						}
						else
						{
							wfDebug( "Don't use WatchUserPageCondition class for user:" . $user->getName(). " (" . $user->getID() . ")");
							$eventsCond->switchOffMessage();
						}
					}
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
function wfWatchUserPageCondition($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags)
{
	return WatchUserPageCondition::execute($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags);
}

?>
