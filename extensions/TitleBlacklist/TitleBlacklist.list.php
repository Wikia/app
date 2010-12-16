<?php
/**
 * Title Blacklist class
 * @author VasilievVV
 * @copyright © 2007 VasilievVV
 * @license GNU General Public License 2.0 or later
 * @file
 */

//@{
/**
 * @package MediaWiki
 * @subpackage Extensions
 */

/**
 * Implements a title blacklist for MediaWiki
 */
class TitleBlacklist {
	private $mBlacklist = null, $mWhitelist = null;
	const VERSION = 2;	//Blacklist format

	/**
	 * Load all configured blacklist sources
         */
	public function load() {
		global $wgTitleBlacklistSources, $wgMemc, $wgTitleBlacklistCaching;
		wfProfileIn( __METHOD__ );
		//Try to find something in the cache
		$cachedBlacklist = $wgMemc->get( wfMemcKey( "title_blacklist_entries" ) );
		if( is_array( $cachedBlacklist ) && count( $cachedBlacklist ) > 0 && ( $cachedBlacklist[0]->getFormatVersion() == self::VERSION ) ) {
			
			$this->mBlacklist = $cachedBlacklist;
			wfProfileOut( __METHOD__ );
			return;
		}

		$sources = $wgTitleBlacklistSources;
		$sources[] = array( 'type' => TBLSRC_MSG );
		$this->mBlacklist = array();
		foreach( $sources as $source ) {
			$this->mBlacklist = array_merge( $this->mBlacklist, $this->parseBlacklist( $this->getBlacklistText( $source ) ) );
		}
		$wgMemc->set( wfMemcKey( "title_blacklist_entries" ), $this->mBlacklist, $wgTitleBlacklistCaching['expiry'] );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Load all configured whitelist sources
         */
	public function loadWhitelist() {
		global $wgMemc, $wgTitleBlacklistCaching;
		wfProfileIn( __METHOD__ );
		$cachedWhitelist = $wgMemc->get( wfMemcKey( "title_whitelist_entries" ) );
		if( is_array( $cachedWhitelist ) && count( $cachedWhitelist ) > 0 && ( $cachedWhitelist[0]->getFormatVersion() != self::VERSION ) ) {
			$this->mWhitelist = $cachedWhitelist;
			wfProfileOut( __METHOD__ );
			return;
		}
		$this->mWhitelist = $this->parseBlacklist( wfMsgForContent( 'titlewhitelist' ) );
		$wgMemc->set( wfMemcKey( "title_whitelist_entries" ), $this->mWhitelist, $wgTitleBlacklistCaching['expiry'] );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get the text of a blacklist from a specified source
	 *
	 * @param $source A blacklist source from $wgTitleBlacklistSources
	 * @return The content of the blacklist source as a string
         */
	private static function getBlacklistText( $source ) {
		if( !is_array( $source ) || count( $source ) <= 0 ) {
			return '';	//Return empty string in error case
		}

		if( $source['type'] == TBLSRC_MSG ) {
			return wfMsgForContent( 'titleblacklist' );
		} elseif( $source['type'] == TBLSRC_LOCALPAGE && count( $source ) >= 2 ) {
			$title = Title::newFromText( $source['src'] );
			if( is_null( $title ) ) {
				return '';
			}
			if( $title->getNamespace() == NS_MEDIAWIKI ) {	//Use wfMsgForContent() for getting messages
				$msg = wfMsgForContent( $title->getText() );
				if( !wfEmptyMsg( 'titleblacklist', $msg ) ) {
					return $msg;
				} else {
					return '';
				}
			} else {
				$article = new Article( $title );
				if( $article->exists() ) {
					$article->followRedirect();
					return $article->getContent();
				}
			}
		} elseif( $source['type'] == TBLSRC_URL && count( $source ) >= 2 ) {
			return self::getHttp( $source['src'] );
		} elseif( $source['type'] == TBLSRC_FILE && count( $source ) >= 2 ) {
			if( file_exists( $source['src'] ) ) {
				return file_get_contents( $source['src'] );
			} else {
				return '';
			}
		}

		return '';
	}
	
	/**
	 * Parse blacklist from a string
	 *
	 * @param $list Text of a blacklist source, as a string
	 * @return An array of TitleBlacklistEntry entries
         */
	public static function parseBlacklist( $list ) {
		wfProfileIn( __METHOD__ );
		$lines = preg_split( "/\r?\n/", $list );
		$result = array();
		foreach ( $lines as $line )
		{
			$line = TitleBlacklistEntry :: newFromString( $line );
			if ( $line ) {
				$result[] = $line;
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Check whether the blacklist restricts the current User from 
	 * performing a specific action on the given Title
	 *
	 * @param $title Title to check
	 * @param $action Action to check; 'edit' if unspecified
	 * @return The corresponding TitleBlacklistEntry if blacklisted;
	 *         otherwise FALSE
         */
	public function isBlacklisted( $title, $action = 'edit' ) {
		global $wgUser;
		if( !($title instanceof Title) ) {
			$title = Title::newFromText( $title );
		}
		$blacklist = $this->getBlacklist();
		foreach ( $blacklist as $item ) {
			if( !$item->userCan( $title, $wgUser, $action ) ) {
				if( $this->isWhitelisted( $title, $action ) ) {
					return false;
				}
				return $item;
			}
		}
		return false;
	}
	
	/**
	 * Check whether it has been explicitly whitelisted that the 
	 * current User may perform a specific action on the given Title
	 *
	 * @param $title Title to check
	 * @param $action Action to check; 'edit' if unspecified
	 * @return TRUE if whitelisted; otherwise FALSE
         */
	public function isWhitelisted( $title, $action = 'edit' ) {
		global $wgUser;
		if( !($title instanceof Title) ) {
			$title = Title::newFromText( $title );
		}
		$whitelist = $this->getWhitelist();
		foreach( $whitelist as $item ) {
			if( !$item->userCan( $title, $wgUser, $action ) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Get the current blacklist
	 *
	 * @return Array of TitleBlacklistEntry items
         */
	public function getBlacklist() {
		if( is_null( $this->mBlacklist ) ) {
			$this->load();
		}
		return $this->mBlacklist;
	}
	
	/*
	 * Get the current whitelist
	 *
	 * @return Array of TitleBlacklistEntry items
         */
	public function getWhitelist() {
		if( is_null( $this->mWhitelist ) ) {
			$this->loadWhitelist();
		}
		return $this->mWhitelist;
	}
	
	/**
	 * Get the text of a blacklist source via HTTP
	 *
	 * @param $source URL of the blacklist source
	 * @return The content of the blacklist source as a string
         */
	private static function getHttp( $url ) {
		global $messageMemc, $wgTitleBlacklistCaching;
		$key = "title_blacklist_source:" . md5( $url ); // Global shared
		$warnkey = wfMemcKey( "titleblacklistwarning", md5( $url ) );
		$result = $messageMemc->get( $key );
		$warn = $messageMemc->get( $warnkey );
		if ( !is_string( $result ) || ( !$warn && !mt_rand( 0, $wgTitleBlacklistCaching['warningchance'] ) ) ) {
			$result = Http::get( $url );
			$messageMemc->set( $warnkey, 1, $wgTitleBlacklistCaching['warningexpiry'] );
			$messageMemc->set( $key, $result, $wgTitleBlacklistCaching['expiry'] );
		}
		return $result;
	}
	
	/**
	 * Invalidate the blacklist cache
	 */
	public function invalidate() {
		global $wgMemc;
		$wgMemc->delete( wfMemcKey( "title_blacklist_entries" ) );
	}
	
	/**
	 * Validate a new blacklist
	 *
	 * @param $list Text of the new blacklist, as a string
	 * @return Array of bad entries; empty array means blacklist is valid
	 */
	public function validate( $blacklist ) {
		$badEntries = array();
		foreach( $blacklist as $e ) {
			wfSuppressWarnings();
			$regex = $e->getRegex();
			if( preg_match( "/{$regex}/u", '' ) === false )
				$badEntries[] = $e->getRaw();
			wfRestoreWarnings();
		}
		return $badEntries;
	}
}


/**
 * Represents a title blacklist entry
 */
class TitleBlacklistEntry {
	private
		$mRaw,           ///< Raw line
		$mRegex,         ///< Regular expression to match
		$mParams,        ///< Parameters for this entry
		$mFormatVersion; ///< Entry format version

	/**
	 * Construct a new TitleBlacklistEntry.
	 *
	 * @param $regex Regular expression to match
	 * @param $params Parameters for this entry
	 * @param $raw Raw contents of this line
	 */
	private function __construct( $regex, $params, $raw ) {
		$this->mRaw = $raw;
		$this->mRegex = $regex;
		$this->mParams = $params;
		$this->mFormatVersion = TitleBlacklist::VERSION;
	}

	/**
	 * Check whether the specified User can perform the specified action 
	 * on the specified Title
	 *
	 * @param $title Title to check
	 * @param $user User to check
	 * @param $action %Action to check
	 * @return TRUE if the user can; otherwise FALSE
	 */
	public function userCan( $title, $user, $action ) {
		if( $user->isAllowed( 'tboverride' ) ) {
			return true;
		}
		wfSuppressWarnings();
		$match = preg_match( "/^(?:{$this->mRegex})$/us" . ( isset( $this->mParams['casesensitive'] ) ? '' : 'i' ), $title->getFullText() );
		wfRestoreWarnings();
		if( $match ) {
			if( isset( $this->mParams['autoconfirmed'] ) && $user->isAllowed( 'autoconfirmed' ) ) {
				return true;
			}
			if( isset( $this->mParams['moveonly'] ) && $action != 'move' ) {
				return true;
			}
			if( isset( $this->mParams['newaccountonly'] ) && $action != 'new-account' ) {
				return true;
			}
			if( !isset( $this->mParams['noedit'] ) && $action == 'edit' ) {
				return true;
			}
			if ( isset( $this->mParams['reupload'] ) && $action == 'upload' ) {
				// Special:Upload also checks 'create' permissions when not reuploading
				return true;
			}
			return false;
		}
		return true;
	}

	/**
	 * Create a new TitleBlacklistEntry from a line of text
	 *
	 * @param $line String containing a line of blacklist text
	 * @return A new corresponding TitleBlacklistEntry
	 */
	public static function newFromString( $line ) {
		$raw = $line; // Keep line for raw data
		$regex = "";
		$options = array();
		// Strip comments
		$line = preg_replace( "/^\\s*([^#]*)\\s*((.*)?)$/", "\\1", $line );
		$line = trim( $line );
		// Parse the rest of message
		preg_match( '/^(.*?)(\s*<([^<>]*)>)?$/', $line, $pockets );
		@list( $full, $regex, $null, $opts_str ) = $pockets;
		$regex = trim( $regex );
		$regex = str_replace( '_', ' ', $regex ); // We'll be matching against text form
		$opts_str = trim( $opts_str );
		// Parse opts
		$opts = preg_split( '/\s*\|\s*/', $opts_str );
		foreach( $opts as $opt ) {
			$opt2 = strtolower( $opt );
			if( $opt2 == 'autoconfirmed' ) {
				$options['autoconfirmed'] = true;
			}
			if( $opt2 == 'moveonly' ) {
				$options['moveonly'] = true;
			}
			if( $opt2 == 'newaccountonly' ) {
				$options['newaccountonly'] = true;
			}
			if( $opt2 == 'noedit' ) {
				$options['noedit'] = true;
			}
			if( $opt2 == 'casesensitive' ) {
				$options['casesensitive'] = true;
			}
			if( $opt2 == 'reupload' ) {
				$options['reupload'] = true;
			}
			if( preg_match( '/errmsg\s*=\s*(.+)/i', $opt, $matches ) ) {
				$options['errmsg'] = $matches[1];
			}
		}
		// Process magic words
		preg_match_all( '/{{\s*([a-z]+)\s*:\s*(.+?)\s*}}/', $regex, $magicwords, PREG_SET_ORDER );
		foreach( $magicwords as $mword ) {
			global $wgParser;	// Functions we're calling don't need, nevertheless let's use it
			switch( strtolower( $mword[1] ) ) {
				case 'ns':
					$cpf_result = CoreParserFunctions::ns( $wgParser, $mword[2] );
					if( is_string( $cpf_result ) ) {
						$regex = str_replace( $mword[0], $cpf_result, $regex );	// All result will have the same value, so we can just use str_seplace()
					}
					break;
				case 'int':
					$cpf_result = wfMsgForContent( $mword[2] );
					if( is_string( $cpf_result ) ) {
						$regex = str_replace( $mword[0], $cpf_result, $regex );
					}
			}
		}
		// Return result
		if( $regex ) {
			return new TitleBlacklistEntry( $regex, $options, $raw );
		} else {
			return null;
		}
	}
	
	/**
	 * @returns This entry's regular expression
	 */
	public function getRegex() {
		return $this->mRegex;
	}

	/**
	 * @returns This entry's raw line
	 */
	public function getRaw() {
		return $this->mRaw;
	}

	/**
	 * @returns This entry's options
	 */
	public function getOptions() {
		return $this->mOptions;
	}

	/**
	 * @returns Custom message for this entry
	 */
	public function getCustomMessage() {
		return isset( $this->mParams['errmsg'] ) ? $this->mParams['errmsg'] : null;
	}
	
	/**
	 * @returns The format version
	 */
	public function getFormatVersion() { return $this->mFormatVersion; }

	/**
	 * Set the format version
	 *
	 * @param $v New version to set
	 */
	public function setFormatVersion( $v ) { $this->mFormatVersion = $v; }
}

//@}