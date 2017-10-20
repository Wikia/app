<?php

$wgWikiaNewtalkExpiry = 300;

/**
 * Generate a memcache key for given user's shared message cache
 *
 * Either user's ID (logged-in) or his IP (anon) will be used
 *
 * @param User $user
 * @return string
 */
function wfWikiaNewTalkMemcKey( User $user ) {
	return wfSharedMemcKey( 'WikiaSharedNewTalk', $user->isLoggedIn() ? $user->getId() : $user->getName() );
}

/**
 * Return a WHERE condition that will match either entries for an anon (by IP address) or a user account (by user ID).
 *
 * Wiki ID (e.g. "muppet") will be included if $includeWikiId argument is set to true.
 *
 * @see SUS-3076
 * @param User $user
 * @param boolean $includeWikiId
 * @return array
 */
function wfBuildNewtalkWhereCondition( User $user, $includeWikiId = false ) : array {
	$wikiCondition = $includeWikiId ? [ 'sn_wiki' => wfWikiID() ] : [];

	if ( $user->isAnon() ) {
		return array_merge( $wikiCondition, [ 'sn_user_ip' => $user->getName() ] );
	}
	else {
		return array_merge( $wikiCondition, [ 'sn_user_id' => $user->getID() ] );
	}
}

/**
 * wfSetWikiaNewtalk
 *
 * Hook, set new wikia shared message
 *
 * @author
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> (changes)
 * @access public
 *
 * @param WikiPage $article: edited article
 *
 * @return bool: don't go to next hook
 */
function wfSetWikiaNewtalk( WikiPage $article ): bool {
	global $wgMemc, $wgExternalSharedDB;
	$name = $article->mTitle->getDBkey();
	$other = User::newFromName( $name );

    if( !($other instanceof User) && User::isIP( $name ) ) {
		// An anonymous user
		$other = new User();
		$other->setName( $name );
	}

    if( $other instanceof User ) {
		$other->setNewtalk( true );
		$other->load();
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

        $dbw->begin();

		/**
		 * first delete
		 */
		$dbw->delete(
            "shared_newtalks",
            wfBuildNewtalkWhereCondition( $other, true ),
            __METHOD__
        );
        /**
		 * then insert
		 */
		$dbw->insert(
            "shared_newtalks",
            wfBuildNewtalkWhereCondition( $other, true ),
            __METHOD__
        );
        $dbw->commit();
		$wgMemc->delete( wfWikiaNewTalkMemcKey( $other ) );
	}
	return false;
}

/**
 * @param User $user
 * @param $talks
 * @return bool
 */
function wfGetWikiaNewtalk( User $user, &$talks ) {
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
	$key = wfWikiaNewTalkMemcKey( $user );
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
			wfBuildNewtalkWhereCondition( $user ),
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
				// TODO: use GlobalTitle
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
function wfClearWikiaNewtalk( User $user ) {
	global $wgMemc, $wgExternalSharedDB;

	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
	$dbw->delete(
        "shared_newtalks",
        wfBuildNewtalkWhereCondition( $user, true ),
        __METHOD__
    );
	$wgMemc->delete( wfWikiaNewTalkMemcKey( $user ) );
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
 * AJAX method to dismiss all shared messages for current user
 *
 * @author macbre
 */
$wgAjaxExportList[] = 'wfDismissWikiaNewtalks';
function wfDismissWikiaNewtalks() {
	global $wgRequest, $wgUser, $wgMemc, $wgExternalSharedDB;

	$result = false;

	// this request should be posted
	if ($wgRequest->wasPosted()) {
		// shared messages
		Hooks::run( 'DismissWikiaNewtalks', array( $wgUser ) );
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->delete(
			'shared_newtalks',
			wfBuildNewtalkWhereCondition( $wgUser ),
			__METHOD__
		);
		$dbw->commit();

		// local messages
		$wgUser->setNewtalk(false);

		$dbw = wfGetDB(DB_MASTER);
		$dbw->commit();

		$wgMemc->delete( wfWikiaNewTalkMemcKey( $wgUser ) );

		$result = true;
	}

	$json = json_encode(array('result' => $result));

	$response = new AjaxResponse($json);
	$response->setContentType('application/json; charset=utf-8');
	return $response;
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
