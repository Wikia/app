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
class WelcomeVisitorCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$out) 
	{
		global $wgSharedDB, $wgDBname, $wgUser, $wgEnableSystemEvents;
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
				$isCookie = (empty($_COOKIE) || empty($_COOKIE['wgWikiaUniqueBrowserId'])) ? false : true;
				if ($eventsCond)
				{
					# check event condition
					if ( ($wgUser->IsAnon()) && (!$isCookie) )
					{
						wfDebug( "Execute WelcomeVisitorCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
						$eventsCond->executeCondition();
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

function wfWelcomeVisitorCondition($ev_id, &$out)
{
	return WelcomeVisitorCondition::execute($ev_id, &$out);
}

?>
