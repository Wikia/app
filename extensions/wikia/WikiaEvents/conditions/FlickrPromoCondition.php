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
class FlickrPromoCondition 
{
	#---
	function __construct() 
	{
		// __CLASS__ contructor
	}
	
	#---
	static public function execute($ev_id /*obligatory*/, /*hook's parameters*/ &$out) 
	{
		global $wgTitle, $wgUser, $wgEnableSystemEvents;
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
					$namespace = $wgTitle->getNamespace();
					$articleID = $wgTitle->getArticleID();
					$isProtected = $wgTitle->isProtected();
					if ( ($wgUser->isLoggedIn()) && ($articleID) && (!$isProtected) && (in_array($namespace, array(NS_IMAGE))) )
					{
						wfDebug( "Execute FlockrPromoCondition for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
						$eventsCond->executeCondition(1);
					}
					else
					{
						wfDebug( "Don't use FlockrPromoCondition class for user:" . $wgUser->getName(). " (" . $wgUser->getID() . ")");
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
function wfFlickrPromoCondition($ev_id, &$out)
{
	return FlickrPromoCondition::execute($ev_id, &$out);
}

?>
