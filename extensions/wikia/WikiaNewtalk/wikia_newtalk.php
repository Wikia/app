<?php

$wgWikiaNewtalkExpiry = 300;

/**
 * wfSetWikiaNewtalk
 *
 * Hook, set new wikia shared message
 *
 * @author
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> (changes)
 * @access public
 *
 * @param Article $article: edited article
 *
 * @return false: don't go to next hook
 */
function wfSetWikiaNewtalk( &$article ) {
	global $wgMemc, $wgWikiaNewtalkExpiry, $wgExternalSharedDB;
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
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

        $dbw->begin();

		/**
		 * first delete
		 */
		$dbw->delete(
            "shared_newtalks",
            array(
                'sn_wiki' => wfWikiID(),
                'sn_user_id' => $other->getID(),
                'sn_user_ip' => $other->getName()
    		),
            __METHOD__
        );
        /**
		 * then insert
		 */
		$dbw->insert(
            "shared_newtalks",
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
	global $wgMemc, $wgWikiaNewtalkExpiry, $wgExternalSharedDB;

	# hack: don't check it for our varnish ip addresses
	global $wgSquidServers, $wgSquidServersNoPurge;
	if( !$user->mId && (
		in_array( $user->getName(), $wgSquidServers ) ||
		in_array( $user->getName(), $wgSquidServersNoPurge )
	) ) {
		return true;
	}
	wfProfileIn( __METHOD__ );
	$key = 'wikia:shared_newtalk:'.$user->getID().':'.str_replace( ' ', '_', $user->getName() );
	$wikia_talks = $wgMemc->get( $key );
	if( !is_array( $wikia_talks ) ) {
		$wikia_talks = array();

		// Get the data from master. Otherwise we may get the data 
		// from a lagged slave. The effect for the user would be 
		// that he can't clear his user talk notice (the data are 
		// removed on master but not replicated to the slave yet).
		$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$sth = $dbr->select(
			array( "shared_newtalks" ),
			array( "sn_wiki" ),
			array(
				"sn_user_id" => $user->getID(),
				"sn_user_ip" => $user->getName()
			),
			__METHOD__,
			array( "LIMIT" => 255 )
		);
		$wikis = array();
		while( $row = $dbr->fetchObject( $sth ) ) {
			$wikis[] = $row->sn_wiki;
		}
		$dbr->freeResult( $sth );

		if( count( $wikis ) ) {
			$sth = $dbr->select(
				'city_list',
				array( "city_id", "city_title", "city_url", "city_dbname" ),
				array(
					  $dbr->makeList( array( "city_dbname" => $wikis ), LIST_OR ),
					  "city_public" => 1
				),
				__METHOD__
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$link = $row->city_url . 'index.php?title=User_talk:' . urlencode($user->getTitleKey());
				$wiki = empty( $row->city_title ) ? $row->city_dbname : $row->city_title;
				$wikia_talks[ $row->city_id ] = array( 'wiki' => $wiki, 'link' => $link );
			}
			$dbr->freeResult( $sth );
		}
		$wgMemc->set( $key, $wikia_talks, $wgWikiaNewtalkExpiry );
	}

	if( is_array( $wikia_talks ) && count( $wikia_talks ) > 0 ) {
		$talks += $wikia_talks;
	}

	wfProfileOut( __METHOD__ );

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
function wfClearWikiaNewtalk( &$user ) {
	global $wgMemc, $wgExternalSharedDB;

	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
	$dbw->delete(
        "shared_newtalks",
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

function WikiaNewtalkUserRenameGlobal( $dbw, $uid, $oldusername, $newusername, $process, &$tasks ) {
	$tasks[] = array(
		'table' => 'shared_newtalks',
		'username_column' => 'sn_user_ip',
		'userid_column' => 'sn_user_id',
	);
	return true;
}

/**
 * register Hooks
 */
if( !empty( $wgExternalSharedDB ) ) {
	global $wgHooks;
	$wgHooks['UserRetrieveNewTalks'][] = 'wfGetWikiaNewtalk';
	$wgHooks['ArticleEditUpdateNewTalk'][] = 'wfSetWikiaNewtalk';
	$wgHooks['UserClearNewTalkNotification'][] = 'wfClearWikiaNewtalk';

	$wgHooks['UserRename::Global'][] = "WikiaNewtalkUserRenameGlobal";

}
