<?php
/**
 * All hooked functions used by VoteNY extension.
 *
 * @file
 * @ingroup Extensions
 */
class VoteHooks {

	/**
	 * Set up the <vote> parser hook.
	 *
	 * @param $parser Parser: instance of Parser
	 * @return Boolean: true
	 */
	public static function registerParserHook( &$parser ) {
		$parser->setHook( 'vote', array( 'VoteHooks', 'renderVote' ) );
		return true;
	}

	/**
	 * Callback function for registerParserHook.
	 *
	 * @param $input String: user-supplied input, unused
	 * @param $args Array: user-supplied arguments, unused
	 * @param $parser Parser: instance of Parser, unused
	 * @return String: HTML
	 */
	public static function renderVote( $input, $args, $parser ) {
		global $wgOut;

		wfProfileIn( __METHOD__ );

		// Disable parser cache (sadly we have to do this, because the caching is
		// messing stuff up; we want to show an up-to-date rating instead of old
		// or totally wrong rating, i.e. another page's rating...)
		$parser->disableCache();

		// Add CSS & JS
		// In order for us to do this *here* instead of having to do this in
		// registerParserHook(), we must've disabled parser cache
		$wgOut->addModules( 'ext.voteNY' );

		// Define variable - 0 means that we'll get that green voting box by default
		$type = 0;

		// Determine what kind of a voting gadget the user wants: a box or pretty stars?
		if(	preg_match( "/^\s*type\s*=\s*(.*)/mi", $input, $matches ) ) {
			$type = htmlspecialchars( $matches[1] );
		} elseif( !empty( $args['type'] ) ) {
			$type = intval( $args['type'] );
		}

		$articleID = $wgOut->getTitle()->getArticleID();
		switch( $type ) {
			case 0:
				$vote = new Vote( $articleID );
				break;
			case 1:
				$vote = new VoteStars( $articleID );
				break;
			default:
				$vote = new Vote( $articleID );
		}

		$output = $vote->display();

		wfProfileOut( __METHOD__ );

		return $output;
	}

	/**
	 * For the Renameuser extension.
	 *
	 * @param $renameUserSQL
	 * @return Boolean: true
	 */
	public static function onUserRename( $renameUserSQL ) {
		$renameUserSQL->tables['Vote'] = array( 'username', 'vote_user_id' );
		return true;
	}

	/**
	 * Assign a value to {{NUMBEROFVOTES}}. First we try memcached and if that
	 * fails, we fetch it directly from the database and cache it for 24 hours.
	 *
	 * @param $parser Parser
	 * @param $cache
	 * @param $magicWordId String: magic word ID
	 * @param $ret Integer: return value (number of votes)
	 * @return Boolean: true
	 */
	public static function assignValueToMagicWord( &$parser, &$cache, &$magicWordId, &$ret ) {
		global $wgMemc;

		if ( $magicWordId == 'NUMBEROFVOTES' ) {
			$key = wfMemcKey( 'vote', 'magic-word' );
			$data = $wgMemc->get( $key );
			if ( $data != '' ) {
				// We have it in cache? Oh goody, let's just use the cached value!
				wfDebugLog(
					'VoteNY',
					'Got the amount of votes from memcached'
				);
				// return value
				$ret = $data;
			} else {
				// Not cached → have to fetch it from the database
				$dbr = wfGetDB( DB_SLAVE );
				$voteCount = (int)$dbr->selectField(
					'Vote',
					'COUNT(*) AS count',
					array(),
					__METHOD__
				);
				wfDebugLog( 'VoteNY', 'Got the amount of votes from DB' );
				// Store the count in cache...
				// (86400 = seconds in a day)
				$wgMemc->set( $key, $voteCount, 86400 );
				// ...and return the value to the user
				$ret = $voteCount;
			}
		}
		return true;
	}

	/**
	 * Register the magic word ID for {{NUMBEROFVOTES}}.
	 *
	 * @param $variableIds Array: array of pre-existing variable IDs
	 * @return Boolean: true
	 */
	public static function registerVariableId( &$variableIds ) {
		$variableIds[] = 'NUMBEROFVOTES';
		return true;
	}

	/**
	 * Creates the necessary database table when the user runs
	 * maintenance/update.php.
	 *
	 * @param $updater DatabaseUpdater
	 * @return Boolean: true
	 */
	public static function addTable( $updater ) {
		$dir = dirname( __FILE__ );
		$file = "$dir/vote.sql";
		$updater->addExtensionUpdate( array( 'addTable', 'Vote', $file, true ) );
		return true;
	}
}