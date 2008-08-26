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
class CreateArticleCondition 
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
					$userEditCount = $user->getEditCount();
					if ( ($wgUser->getID() == $user->getID()) && 
						($user->isLoggedIn()) && 
						(in_array($article->getTitle()->getNamespace(), array(NS_MAIN, NS_USER))) )
					{
						wfDebug( "Execute CreateArticleCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
						$eventsCond->executeCondition();
					}
					else
					{
						wfDebug( "Don't use CreateArticleCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
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
function wfCreateArticleCondition($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags)
{
	return CreateArticleCondition::execute($ev_id, &$article, &$user, $text, $summary, $minor_flag, $opt1, $opt2, &$flags);
}

?>
