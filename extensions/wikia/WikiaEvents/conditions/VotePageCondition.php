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
 * check conditions for welcome's site event
 * 
 */
class VotePageCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$out) 
	{
		global $wgSharedDB, $wgDBname, $wgUser, $wgEnableSystemEvents;
		global $wgTitle;
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
					if ($wgUser->isLoggedIn()) 
					{
						$isUserVoteAnyPage = $eventsCond->getUserCountVotes($wgUser->getID());
						#---
						$canVote = $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $out->isArticle(); 
						#---
						if ( empty($isUserVoteAnyPage) && ($canVote) )  
						{
							wfDebug( "Execute VotePageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
							$eventsCond->executeCondition();
						}
						else
						{
							wfDebug( "Don't use VotePageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
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
function wfVotePageCondition($ev_id, &$out)
{
	return VotePageCondition::execute($ev_id, &$out);
}

?>
