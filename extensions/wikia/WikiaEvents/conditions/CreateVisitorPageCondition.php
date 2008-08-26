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
class CreateVisitorPageCondition 
{
	#---
	const EVENT_KEY = 'createvisitorpage';
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
						if ( ($wgUser->isAnon()) && (empty($userPageId)) && (!empty($_COOKIE['wgWikiaUniqueBrowserId'])) )
						{
							wfDebug( "Execute CreateVisitorPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
							$eventsCond->executeCondition();
						}
						/*else
						{
							wfDebug( "Don't use CreateVisitorPageCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
							$eventsCond->switchOffMessage();
						}*/
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

function wfCreateVisitorPageCondition($ev_id, &$edit_page)
{
	return CreateVisitorPageCondition::execute($ev_id, &$edit_page);
}

?>
