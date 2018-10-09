<?php

class Masthead {

	/**
	 * default avatar path
	 */
	const DEFAULT_PATH = '/messaging/images/';

	const DEFAULT_AVATAR_FILENAME = 'Avatar.jpg';

	/**
	 * path to file, relative
	 */
	public $mPath = false;

	/**
	 * user object
	 */
	public $mUser = false;

	/**
	 * avatars from mediawiki message
	 *
	 * @var array $mDefaultAvatars
	 */
	public $mDefaultAvatars = false;

	/**
	 * custom URL to avatar - if set, will be overriden
	 */
	public $avatarUrl = null;

	/**
	 * custom URL to user page - if set, will be overriden
	 */
	public $userPageUrl = null;

	public function __construct( $user = null ) {
		wfProfileIn( __METHOD__ );
		if ( !empty( $user ) && ( $user instanceof User ) ) {
			$this->mUser = $user;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUser( User $User ) {
		return new Masthead( $User );
	}

	/**
	 * static constructor
	 * @static
	 * @access public
	 */
	public static function newFromUserID( $userId ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromId( $userId );
		$User->load();
		$Avatar = new Masthead( $User );

		wfProfileOut( __METHOD__ );

		return $Avatar;
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUserName( $login ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromName( $login );
		if ( $User ) {
			$User->load();
			$Avatar = new Masthead( $User );
		} else {
			/**
			 * anonymous
			 */
			$Avatar = Masthead::newFromUserID( 0 );
		}
		wfProfileOut( __METHOD__ );

		return $Avatar;
	}

	public static function getAvatarDefaultPath( ) {
		global $wgVignetteUrl;

		return $wgVignetteUrl . self::DEFAULT_PATH;
	}

	/**
	 * joinUrlPath -- utility function to properly concatenate url segments to avoid double '/'
	 *
	 * @param String|string[] ...$segments -- any number of parameters which should be concatenated together
	 * @return string
	 */
	private static function joinUrlPath( string ...$segments ) {
		$url = [];
		foreach ( $segments as $segment ) {
			$part = trim( $segment, '/' );
			if ( $part !== "" ) {
				$url[] = $part;
			}
		}
		return implode( $url, '/' );
	}

	/**
	 * getDefaultAvatars -- get avatars stored in mediawiki message and return as
	 *    array
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @return array -- array with default avatars defined on messaging.wikia.com
	 */
	public function getDefaultAvatars( $thumb = "" ) {

		/**
		 * parse message only once per request
		 */
		if ( $thumb == "" && is_array( $this->mDefaultAvatars ) && count( $this->mDefaultAvatars ) > 0 ) {
			return $this->mDefaultAvatars;
		}

		wfProfileIn( __METHOD__ );

		$this->mDefaultAvatars = array();
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' ) ?: [ static::DEFAULT_AVATAR_FILENAME ]; // PLATFORM-2393: add a default value

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$hash = FileRepo::getHashPathForLevel( $image, 2 );
				$url = self::joinUrlPath( self::getAvatarDefaultPath(), $thumb, $hash, $image, "/revision/latest" );
				$this->mDefaultAvatars[] = $url;
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->mDefaultAvatars;
	}

	/**
	 * getUserName
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function getUserName() {
		$username = '';
		if ( isset( $this->mUser ) ) {
			$username = $this->mUser->getName();
		}

		return $username;
	}

	/**
	 * setUserPageUrl -- set url for user page
	 *
	 * @access public
	 */
	public function setUserPageUrl( $url ) {
		$this->userPageUrl = $url;
	}

	/**
	 * getUserPageUrl -- url for user page
	 *
	 * @access public
	 */
	public function getUserPageUrl() {
		if ( isset( $this->userPageUrl ) )
			$url = $this->userPageUrl;
		else
			$url = $this->mUser->getUserPage()->getFullUrl();

		return $url;
	}

	/**
	 * setUrl -- set url for avatar - if set, it will override default behavior
	 *
	 * @access public
	 */
	public function setUrl( $url ) {
		$this->avatarUrl = $url;
	}

	/**
	 * getUrl -- read url from preferences or from defaults if preference is
	 * not set.
	 *
	 * @access public
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @return String
	 */
	public function getUrl( $thumb = "" ) {
		if ( !empty( $this->avatarUrl ) ) {
			return $this->avatarUrl;
		} else {
			$url = $this->getPurgeUrl( $thumb ); // get the basic URL
			return wfReplaceImageServer( $url, $this->mUser->getTouched() );
		}
	}

	/**
	 * Return a full avatar for a given default avatar
	 *
	 * @param string $avatar (e.g. Avatar3.jpg)
	 * @param string $revision (e.g. latest)
	 * @return string full URL (e.g. http://images.wikia.com/messaging/images/4/46/Avatar3.jpg)
	 */
	public static function getDefaultAvatarUrl( $avatar, $revision = 'latest' ) {
		/**
		 * default avatar, path from messaging.wikia.com
		 */
		$hash = FileRepo::getHashPathForLevel( $avatar, 2 );

		return self::getAvatarDefaultPath() . $hash . $avatar . ($revision !== "" ? "/revision/$revision" : "");
	}

	/**
	 * getPurgeUrl -- the basic URL (without image server rewriting, cachebuster,
	 * etc.) of the avatar.  This can be sent to squid to purge it.
	 *
	 * @access public
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @return String
	 */
	public function getPurgeUrl( $thumb = "" ) {
		global $wgVignetteUrl;
		$url = $this->mUser->getGlobalAttribute( AVATAR_USER_OPTION_NAME );

		if ( $url ) {
			/**
			 * if default avatar we glue with messaging.wikia.com
			 * if uploaded avatar we glue with common avatar path
			 */
			if ( strpos( $url, '/' ) !== false ) {
				/**
				 * uploaded file, we are adding common/avatars path
				 */
				// avatars selected from "samples" are stored as full URLs (BAC-1105)
				// e.g http://vignette.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width/150?format=jpg
				// e.g http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg
				if ( !preg_match( '/^https?:\/\//', $url ) ) {
					$url = "{$wgVignetteUrl}/common/avatars" . rtrim( $thumb, '/' ) . $url . '/revision/latest';
				}
			} else {
				/**
				 * default avatar, path from messaging.wikia.com
				 */
				$url = static::getDefaultAvatarUrl( $url );
			}
		} else {
			$defaults = $this->getDefaultAvatars( trim( $thumb, "/" ) . "/" );
			$url = array_shift( $defaults );
		}

		return $url;
	}

	/**
	 * method for taking scaled avatars
	 * - avatar will be scaled by external image thumbnailer
	 * - external image thumbnailer use only width and scale it with the same
	 *   proportion as original
	 * - currently there's no thumbnail file, it's only cached on varnish and
	 *   generated on fly as needed
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @param width - the width of the thumbnail (height will be same propotion to width as in unscaled image)
	 * @param inPurgeFormat - boolean - if true, then the returned URL will be in the format used for purging
	 *                                  which means it will use images.wikia.com instead of a CDN hostname.
	 *
	 *
	 * @return string -- url to Avatar
	 */
	public function getThumbnail( $width, $inPurgeFormat = false ) {
		if ( $inPurgeFormat ) {
			$url = $this->getPurgeUrl();
		} else {
			$url = $this->getUrl();
		}

		return ImagesService::getThumbUrlFromFileUrl( $url, $width );
	}

	/**
	 * Get the URL in a generic form (ie: images.wikia.com) to be used
	 * for purging thumbnails.
	 *
	 * @access public
	 * @author Sean Colombo
	 *
	 * @param width - the width of the thumbnail (height will be same propotion to width as in unscaled image)
	 * @return string -- url to Avatar on the purgable hostname.
	 */
	public function getThumbnailPurgeUrl( $width ) {
		return $this->getThumbnail( $width, true );
	}

	/**
	 * Returns true if the user whose masthead this is, has an avatar set.
	 * Returns false if they do not (and would end up using the default avatar).
	 */
	public function hasAvatar() {
		$hasAvatar = false;
		if ( !empty( $this->avatarUrl ) ) {
			$hasAvatar = true;
		} else {
			$url = $this->mUser->getGlobalAttribute( AVATAR_USER_OPTION_NAME );
			if ( ( $url ) && ( strpos( $url, '/' ) !== false ) ) {
				// uploaded file
				$hasAvatar = true;
			}
		}

		return $hasAvatar;
	} // end hasAvatar()

	/**
	 * getImageTag -- return HTML <img> tag
	 *
	 * @access public
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String $alt -- alternate text
	 * @param String $class -- which class should be used for element
	 * @param String $id -- DOM identifier
	 */
	public function getImageTag( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false, $class = "avatar", $id = false ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$url = $this->getUrl();

		if ( !$alt ) {
			$alt = '[' . $this->mUser->getName() . ']';
		}
		$attribs = array(
			'src' => $url,
			'border' => 0,
			'width' => $width,
			'height' => $height,
			'alt' => $alt,
		);
		if ( $class ) {
			$attribs['class'] = $class;
			if ( $wgUser->getID() == $this->mUser->getID() ) {
				$attribs['class'] .= ' avatar-self';
			}
		}
		if ( $id ) {
			$attribs['id'] = $id;
		}

		wfProfileOut( __METHOD__ );

		return Xml::element( 'img', $attribs, '', true );
	}

	/**
	 * display -- return image with link to user page
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String $alt -- alternate text
	 * @param String $class -- which class should be used for element
	 * @param String $id -- DOM identifier
	 * @param Boolean $showEditMenu
	 * @param String $tracker -- what tracker to add, if any
	 */
	public function display( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false, $class = "avatar", $id = false, $showEditMenu = false, $tracker = false ) {

		wfProfileIn( __METHOD__ );
		$image = $this->getImageTag( $width, $height, $alt, $class, $id );
		$additionalAttribs = "";
		if ( !empty( $showEditMenu ) ) {
			$showEditDiv = "document.getElementById('wk-avatar-change').style.visibility='visible'";
			$hideEditDiv = "document.getElementById('wk-avatar-change').style.visibility='hidden'";
			$additionalAttribs = "onmouseover=\"{$showEditDiv}\" onmouseout=\"{$hideEditDiv}\"";
		}
		if ( !$this->mUser->isAnon() ) {
			$url = sprintf( '<a href="%s" %s>%s</a>', $this->getUserPageUrl(), $additionalAttribs, $image );
		} else {
			$url = $image;
		}
		wfProfileOut( __METHOD__ );

		return $url;
	}

	/**
	 * getLocalPath -- create file path from user identifier
	 */
	public function getLocalPath() {

		if ( $this->mPath ) {
			return $this->mPath;
		}

		wfProfileIn( __METHOD__ );

		$image = sprintf( '%s.png', $this->mUser->getID() );
		$hash = sha1( (string) $this->mUser->getID() );
		$folder = substr( $hash, 0, 1 ) . '/' . substr( $hash, 0, 2 );

		$this->mPath = "/{$folder}/{$image}";

		wfProfileOut( __METHOD__ );

		return $this->mPath;
	}

	/**
	 * isDefault -- check if user use default avatars
	 */
	public function isDefault() {
		$url = $this->mUser->getGlobalAttribute( AVATAR_USER_OPTION_NAME );
		if ( $url ) {
			# all avatars (including the default ones) are always stored with a full URL
			if ( ( startsWith( $url, 'http://' ) || startsWith( $url, "https://" ) ) && preg_match('#/Avatar\d?.jpg$#', $url) ) {
				return true;
			}

			 # Legacy: default avatar are only filenames without path
			if ( strpos( $url, '/' ) !== false ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Perform avatar remove
	 *
	 * @return bool result
	 */
	private function doRemoveFile() {
		if ( !$this->fileExists() ) {
			return true;
		}

		$service = new UserAvatarsService( $this->mUser->getId() );
		return $service->remove();
	}

	/**
	 * Check if avatar file exists
	 *
	 * @return bool
	 */
	private function fileExists() {
		// default avatar set means that there's no custom one uploaded
		// so there's nothing to delete
		return !$this->isDefault();
	}

	/**
	 * removeFile -- remove file from directory
	 */
	public function removeFile( $addLog = true ) {
		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty( $wgAvatarsMaintenance ) ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		$result = $this->doRemoveFile();

		if ( $result !== false ) {
			// removing default avatars is hanlded by MW even when the service is enabled (PLATFORM-1617)
			if ( $this->isDefault() ) {
				$this->mUser->setGlobalAttribute( AVATAR_USER_OPTION_NAME, "" );
				$this->mUser->saveSettings();
			}

			/* add log */
			if ( !empty( $addLog ) ) {
				$this->__setLogType();
				$sUserText = $this->mUser->getName();
				$mUserPage = Title::newFromText( $sUserText, NS_USER );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$oLogPage->addEntry( 'avatar_rem', $mUserPage, '', array( $sUserText ) );
			}
			/* */
		}
		wfProfileOut( __METHOD__ );

		return $result;
	}

	private function __setLogType() {
		global $wgLogTypes;
		wfProfileIn( __METHOD__ );
		if ( !in_array( AVATAR_LOG_NAME, $wgLogTypes ) ) {
			$wgLogTypes[] = AVATAR_LOG_NAME;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	static public function userMastheadInvalidateCache(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor,
		$flags, $revision, Status &$status, $baseRevId
	): bool {
		if ( !$user->isAnon() ) {
			if ( count( $status->errors ) == 0 ) {
				global $wgMemc;
				$mastheadDataEditCountKey = wfMemcKey( 'mmastheadData-editCount-' . $user->getID() );
				$wgMemc->incr( $mastheadDataEditCountKey );
			}

		}

		return true;
	}
}
