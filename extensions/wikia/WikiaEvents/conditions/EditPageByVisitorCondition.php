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
class EditPageByVisitorCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ $title, &$out) 
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
					$canEdit = $title->userCan('edit');
					if ( (!$wgUser->isLoggedIn()) && (!empty($_COOKIE['wgWikiaUniqueBrowserId'])) && ($canEdit) )
					{
						wfDebug( "Execute EditPageByVisitorCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
						$eventsCond->executeCondition();
					}
					/*else
					{
						wfDebug( "Don't use EditPageByVisitorCondition class for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
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
function wfEditPageByVisitorCondition($ev_id, $title, &$out)
{
	return EditPageByVisitorCondition::execute($ev_id, $title, &$out);
}

?>
