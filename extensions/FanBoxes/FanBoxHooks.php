<?php
/**
 * FanBox extension's hooked function. All class methods are obviously public
 * and static.
 *
 * @file
 * @ingroup Extensions
 */
class FanBoxHooks {

	/**
	 * When a fanbox is moved to a new title, update the records in the fantag
	 * table.
	 *
	 * @param $title Object: Title object representing the old title
	 * @param $newtitle Object: Title object representing the new title
	 * @param $oldid Integer:
	 * @param $newid Integer:
	 * @return Boolean: true
	 */
	public static function updateFanBoxTitle( &$title, &$newtitle, &$user, $oldid, $newid ) {
		if( $title->getNamespace() == NS_FANTAG ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update(
				'fantag',
				array( 'fantag_title' => $newtitle->getText() ),
				array( 'fantag_pg_id' => intval( $oldid ) ),
				__METHOD__
			);
			$dbw->commit();
		}
		return true;
	}

	/**
	 * When a page in the NS_FANTAG namespace is deleted, delete all fantag
	 * records associated with that page.
	 *
	 * @param $article Object: instance of Article or its descendant class
	 * @param $user Object: the User performing the page deletion [unused]
	 * @param $reason String: user-supplied reason for the deletion [unused]
	 * @return Boolean: true
	 */
	public static function deleteFanBox( &$article, &$user, $reason ) {
		global $wgTitle, $wgSupressPageTitle;
		if( $wgTitle->getNamespace() == NS_FANTAG ) {
			$wgSupressPageTitle = true;

			$dbw = wfGetDB( DB_MASTER );

			$s = $dbw->selectRow(
				'fantag',
				array( 'fantag_pg_id', 'fantag_id' ),
				array( 'fantag_pg_id' => intval( $article->getID() ) ),
				__METHOD__
			);
			if ( $s !== false ) {
				// delete fanbox records
				$dbw->delete(
					'user_fantag',
					array( 'userft_fantag_id' => intval( $s->fantag_id ) ),
					__METHOD__
				);

				$dbw->delete(
					'fantag',
					array( 'fantag_pg_id' => intval( $article->getID() ) ),
					__METHOD__
				);
				$dbw->commit();
			}
		}
		return true;
	}

	/**
	 * Convert [[Fan:Fan Name]] tags to <fan></fan> hook
	 *
	 * @param $parser Unused
	 * @param $text String: text to search for [[Fan:]] links
	 * @param $strip_state Unused
	 * @return Boolean: true
	 */
	public static function transformFanBoxTags( &$parser, &$text, &$strip_state ) {
		global $wgContLang;

		$fantitle = $wgContLang->getNsText( NS_FANTAG );
		$pattern = "@(\[\[$fantitle)([^\]]*?)].*?\]@si";
		$text = preg_replace_callback( $pattern, 'FanBoxHooks::renderFanBoxTag', $text );

		return true;
	}

	/**
	 * On preg_replace_callback
	 * Found a match of [[Fan:]], so get parameters and construct <fan> hook
	 *
	 * @param $matches Array
	 * @return String: HTML
	 */
	public static function renderFanBoxTag( $matches ) {
		$name = $matches[2];
		$params = explode( '|', $name );
		$fan_name = $params[0];
		$fan_name = Title::newFromDBKey( $fan_name );

		if( !is_object( $fan_name ) ) {
			return '';
		}

		$fan = FanBox::newFromName( $fan_name->getText() );

		if( $fan->exists() ) {
			$output = "<fan name=\"{$fan->getName()}\"></fan>";
			return $output;
		}

		return $matches[0];
	}

	/**
	 * Calls FanBoxPage instead of standard Article for pages in the NS_FANTAG
	 * namespace.
	 *
	 * @param $title Object: instance of Title
	 * @param $article Object: instance of Article that we transform into an
	 *                         instance of FanBoxPage
	 * @return Boolean: true
	 */
	public static function fantagFromTitle( &$title, &$article ) {
		global $wgRequest, $wgOut, $wgTitle, $wgSupressPageTitle, $wgSupressPageCategories, $wgFanBoxScripts;

		if ( $title->getNamespace() == NS_FANTAG ) {
			$wgSupressPageTitle = true;

			$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );

			if( $wgRequest->getVal( 'action' ) == 'edit' ) {
				$addTitle = SpecialPage::getTitleFor( 'UserBoxes' );
				$fan = FanBox::newFromName( $title->getText() );
				if( !$fan->exists() ) {
					$wgOut->redirect( $addTitle->getFullURL( 'destName=' . $fan->getName() ) );
				} else {
					$update = SpecialPage::getTitleFor( 'UserBoxes' );
					$wgOut->redirect( $update->getFullURL( 'id=' . $wgTitle->getArticleID() ) );
				}
			}

			$article = new FanBoxPage( $wgTitle );
		}

		return true;
	}

	/**
	 * Register the new <fan> hook with the parser.
	 *
	 * @param $parser Object: instance of Parser (not necessarily $wgParser)
	 * @return Boolean: true
	 */
	public static function registerFanTag( &$parser ) {
		$parser->setHook( 'fan', array( 'FanBoxHooks', 'embedFanBox' ) );
		return true;
	}

	/**
	 * Callback function for the registerFanTag() function that expands <fan>
	 * into valid HTML.
	 *
	 * @param $input
	 * @param $argv Array: array of user-supplied arguments
	 * @param $parser Object: instance of Parser
	 * @return String: HTML
	 */
	public static function embedFanBox( $input, $argv, $parser ) {
		global $wgUser, $wgHooks;

		$parser->disableCache();

		$wgHooks['BeforePageDisplay'][] = 'FanBoxHooks::addFanBoxScripts';

		$fan_name = $argv['name'];
		if( !$fan_name ) {
			return '';
		}

		$fan = FanBox::newFromName( $fan_name );

		$output = '';
		if( $fan->exists() ) {
			$output .= $fan->outputFanBox();
			$fantagId = $fan->getFanBoxId();

			$output .= '<div id="show-message-container' . intval( $fantagId ) . '">';
			if( $wgUser->isLoggedIn() ) {
				$check = $fan->checkIfUserHasFanBox();
				if( $check == 0 ) {
					$output .= $fan->outputIfUserDoesntHaveFanBox();
				} else {
					$output .= $fan->outputIfUserHasFanBox();
				}
			} else {
				$output .= $fan->outputIfUserNotLoggedIn();
			}

			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Add FanBox's CSS and JS into the page output.
	 *
	 * @param $out Object: instance of OutputPage
	 * @param $skin Object: instance of Skin or a descendant class
	 * @return Boolean: true
	 */
	public static function addFanBoxScripts( &$out, &$skin ) {
		global $wgFanBoxScripts;
		$out->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );
		$out->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );
		return true;
	}

	/**
	 * Creates the necessary database tables when the user runs
	 * maintenance/update.php.
	 *
	 * @param $updater Object: instance of DatabaseUpdater
	 * @return Boolean: true
	 */
	public static function addTables( $updater = null ) {
		$dir = dirname( __FILE__ );
		$file = "$dir/fantag.sql";
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'fantag', $file );
			$wgExtNewTables[] = array( 'user_fantag', $file );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'fantag', $file, true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'user_fantag', $file, true ) );
		}
		return true;
	}

	/**
	 * For the Renameuser extension.
	 *
	 * @param $renameUserSQL
	 * @return Boolean: true
	 */
	public static function onUserRename( $renameUserSQL ) {
		$renameUserSQL->tables['fantag'] = array(
			'fantag_user_name', 'fantag_user_id'
		);
		$renameUserSQL->tables['user_fantag'] = array(
			'userft_user_name', 'userft_user_id'
		);
		return true;
	}

	/**
	 * Register the canonical names for our namespace and its talkspace.
	 *
	 * @param $list Array: array of namespace numbers with corresponding
	 *                     canonical names
	 * @return Boolean: true
	 */
	public static function onCanonicalNamespaces( &$list ) {
		$list[NS_FANTAG] = 'UserBox';
		$list[NS_FANTAG_TALK] = 'UserBox_talk';
		return true;
	}
}