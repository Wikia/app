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
 * check condition to show user's message after registration
 * 
 */
class WelcomeUserCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ $user) 
	{
		global $wgEnableSystemEvents;
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
					$editCount = $user->getEditCount();
					if ( ($user->isLoggedIn()) && (empty($editCount)) )
					{
						wfDebug( "Execute WelcomeUserCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
						$eventsCond->executeCondition();
					}
					else
					{
						wfDebug( "Don't use WelcomeUserCondition for user:" . $user->getName(). " (" . $user->getID() . ")");
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

function wfWelcomeUserCondition($ev_id, $user)
{
	return WelcomeUserCondition::execute($ev_id, $user);
}

?>
