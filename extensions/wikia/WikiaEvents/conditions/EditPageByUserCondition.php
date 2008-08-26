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
class EditPageByUserCondition 
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
					#--- basic condition
					if ( $title->getArticleID() && (!$title->isProtected()) ) 
					{
						#--- user didn't edit that page ...
						$isPageEditByUser = $eventsCond->checkIsArticleContributor($wgUser, $title->getArticleID());
						$canEdit = $title->userCan('edit');
						#---
						if ( ($wgUser->isLoggedIn()) && (empty($isPageEditByUser)) && ($canEdit) )
						{
							wfDebug( "Execute EditPageByUserCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
							$eventsCond->executeCondition();
						}
						else
						{
							wfDebug( "Don't use EditPageByUserCondition class for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
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
function wfEditPageByUserCondition($ev_id, $title, &$out)
{
	return EditPageByUserCondition::execute($ev_id, $title, &$out);
}

?>
