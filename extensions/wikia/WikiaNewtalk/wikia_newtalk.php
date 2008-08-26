<?php

$wgWikiaNewtalkExpiry = 300;

/**
 * wfSetWikiaNewtalk
 *
 * Hook, set new wikia shared message
 *
 * @author
 * @author eloy@wikia (changes)
 * @access public
 *
 * @param Article $article: edited article
 *
 * @return false: don't go to next hook
 */
function wfSetWikiaNewtalk( &$article )
{
	global $wgSharedDB, $wgMemc, $wgWikiaNewtalkExpiry;
	$name = $article->mTitle->getDBkey();
	$other = User::newFromName( $name );

    if( is_null( $other ) && User::isIP( $name ) ) {
		// An anonymous user
		$other = new User();
		$other->setName( $name );
	}

    if( $other ) {
		$other->setNewtalk( true );
		$other->load();
		$dbw = wfGetDB( DB_MASTER );

        $dbw->begin();
        #--- first delete
		$dbw->delete(
            wfSharedTable("shared_newtalks"),
            array(
                'sn_wiki' => wfWikiID(),
                'sn_user_id' => $other->getID(),
                'sn_user_ip' => $other->getName()
    		),
            __METHOD__
        );
        #--- then insert
		$dbw->insert(
            wfSharedTable("shared_newtalks"),
            array(
                'sn_wiki' => wfWikiID(),
                'sn_user_id' => $other->getID(),
                'sn_user_ip' => $other->getName()
            ),
            __METHOD__
        );
        $dbw->commit();
		$key = 'wikia:shared_newtalk:'.$other->getID().':'.str_replace( ' ', '_', $other->getName() );
		$wgMemc->delete( $key );
	}
	return false;
}

function wfGetWikiaNewtalk( &$user, &$talks ) {
	global $wgSharedDB, $wgMemc, $wgWikiaNewtalkExpiry;

	$key = 'wikia:shared_newtalk:'.$user->getID().':'.str_replace( ' ', '_', $user->getName() );
	$wikia_talks = $wgMemc->get( $key );
	if( !is_array( $wikia_talks ) ) {
		$wikia_talks = array();

		$dbr = wfGetDB( DB_MASTER );
		$tbl_shared_newtalks = wfSharedTable( 'shared_newtalks' );
		$tbl_city_list = wfSharedTable( 'city_list' );
		$res = $dbr->query( "SELECT city_id, sn_wiki, city_title, city_url FROM $tbl_shared_newtalks LEFT OUTER JOIN $tbl_city_list ON city_dbname=sn_wiki WHERE sn_user_id=".$user->getID()." AND sn_user_ip=".$dbr->addQuotes( $user->getName() ) . ' AND city_public = 1');
		while( $row = $dbr->fetchObject( $res ) ) {
			$link = $row->city_url . 'index.php?title=User_talk:' . urlencode($user->getTitleKey());
			$wiki = empty( $row->city_title ) ? $row->sn_wiki : $row->city_title;
			$wikia_talks[$row->city_id] = array( 'wiki' => $wiki, 'link' => $link );
		}

		$wgMemc->set( $key, $wikia_talks, $wgWikiaNewtalkExpiry );
	}
	if( is_array( $wikia_talks ) && count( $wikia_talks ) > 0 ) {
		$talks += $wikia_talks;
	}
	return true;
}

/**
 * wfClearWikiaNewtalk
 *
 * Hook, clear wikia shared message
 *
 * @author
 * @author eloy@wikia (changes)
 * @access public
 *
 * @param User $user: talk page for user
 *
 * @return true: don't stop hook's processing
 */
function wfClearWikiaNewtalk( &$user )
{
	global $wgMemc;

    $dbw = wfGetDB( DB_MASTER );
	$dbw->delete(
        wfSharedTable("shared_newtalks"),
        array(
            'sn_wiki' => wfWikiID(),
            'sn_user_id' => $user->getID(),
            'sn_user_ip' => $user->getName()
        ),
        __METHOD__
    );
	$key = 'wikia:shared_newtalk:'.$user->getID().':'.str_replace( ' ', '_', $user->getName() );
	$wgMemc->delete( $key );
	return true;
}

/**
 * register Hooks
 */
if( isset( $wgSharedDB ) && !( isset( $wgDontWantShared ) && ($wgDontWantShared == true) ) ) {
	global $wgHooks;
	$wgHooks['UserRetrieveNewTalks'][] = 'wfGetWikiaNewtalk';
	$wgHooks['ArticleEditUpdateNewTalk'][] = 'wfSetWikiaNewtalk';
	$wgHooks['UserClearNewTalkNotification'][] = 'wfClearWikiaNewtalk';
}
