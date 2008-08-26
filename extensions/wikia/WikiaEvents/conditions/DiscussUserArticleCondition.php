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
class DiscussUserArticleCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags) 
	{
		global $wgUser, $wgEnableSystemEvents;
		global $wgContentNamespaces, $wgTitle;
		
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
					$isContent = $wgTitle->getNamespace() == NS_MAIN || in_array( $wgTitle->getNamespace(), $wgContentNamespaces );
					$canDiscuss = $isContent && !$wgTitle->isTalkPage(); 

					$userEditCount = $user->getEditCount();
					if (($user->isLoggedIn()) && 
						($userEditCount == 0) && /* so this is first user's edit */
						($canDiscuss))
					{
						wfDebug( "Execute DiscussUserArticleCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
						$eventsCond->executeCondition();
					}
					else
					{
						wfDebug( "Don't use DiscussUserArticleCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
						$eventsCond->switchOffMessage();
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
function wfDiscussUserArticleCondition($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags)
{
	return DiscussUserArticleCondition::execute($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags);
}

?>
