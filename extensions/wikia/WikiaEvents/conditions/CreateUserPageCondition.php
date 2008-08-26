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
 * check conditions if user has own page
 * 
 */
class CreateUserPageCondition 
{
	#---
	const EVENT_KEY = 'createuserpage';
	var $user = null;
	var $article = null;
	
	function __construct() 
	{
		// __CLASS__ contructor
	}

	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ $title, &$tmpContent) 
	{
		global $wgUser, $wgEnableSystemEvents;
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
					$userTitle = Title::makeTitle( NS_USER, $wgUser->getName() );
					$userPageId = $userTitle->getArticleId();
					if ($userTitle)
					{
						$userPageEditCnt = $wgUser->getEditCount();
						if ( ($wgUser->isLoggedIn()) && (empty($userPageId)) && ($userPageEditCnt > 0) )
						{
							wfDebug( "Execute CreateUserPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
							$eventsCond->executeCondition();
						}
						else
						{
							wfDebug( "Don't use CreateUserPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
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

function wfCreateUserPageCondition($ev_id, $title, &$tmpContent)
{
	return CreateUserPageCondition::execute($ev_id, $title, &$tmpContent);
}

?>
