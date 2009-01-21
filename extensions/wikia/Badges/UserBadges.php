<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named TagsReport.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "User Badges",
    "description" => "Generate user badges",
    "author" => "Piotr Molski"
);

define ("USER_BADGES_OPTION_NAME", 'userbadges');

$wgExtensionMessagesFiles["UserBadges"] = dirname(__FILE__) . '/UserBadges.i18n.php';

$wgHooks['AdditionalUserProfilePreferences'][] = "UserBadges::addPreferences";
$wgHooks['SavePreferences'][] = "UserBadges::savePreferences";

class UserBadges {

	/**
	 * path to file, relative
	 */
	public $mPath = false;

	/**
	 * user object
	 */
	public $mUser = false;

	/**
	 * user object
	 */
	public $mCity = false;

	/**
	 * city_id for messaging.wikia.com, will be used for creating image urls
	 */
	private $mMsgCityId = 4036;

	/**
	 * default badge
	 */
	public $mDefaultImg = false;
	
	/**
	 * unserialized options
	 */
	public $mOptions = array();

	public function __construct( User $User ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		$this->mUser = $User;
		$this->mCity = $wgCityId;
		wfLoadExtensionMessages("UserBadges");
		wfProfileOut( __METHOD__ );
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUser( User $User ) {
		return new UserBadges( $User );
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
		$User_badge = new UserBadges( $User );

		wfProfileOut( __METHOD__ );
		return $User_badge;
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
		if( $User ) {
			$User->load();
			$User_badge = new UserBadges( $User );
		} else {
			$User_badge = UserBadges::newFromUserID( 0 );
		}
		wfProfileOut( __METHOD__ );
		return $User_badge;
	}
	
	/**
	 * additionalUserProfilePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param String $html -- generated html
	 */
	static public function addPreferences( &$oPrefs, &$html) {
		global $wgUser, $wgOut;
		global $wgStyleVersion, $wgExtensionsPath;
		global $wgLogo, $wgSitename;
		
		wfProfileIn( __METHOD__ );
		$User_badge = self::newFromUser( $wgUser );
		$sk = $wgUser->getSkin();
		/**
		 * run template
		 */
		#$wgOut->addScript( "<script type=\"text/javascript\" src=\"/skins/common/yui_2.5.2/yahoo-dom-event/yahoo-dom-event.js\"></script>");
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"/skins/common/yui_2.5.2/dragdrop/dragdrop-min.js\"></script> ");
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/Badges/css/UserBadges.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/Badges/js/UserBadges.js\"></script>");
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser"		=> $wgUser,
			"cityId"		=> $User_badge->mCity,
			"sUserBadge"	=> $User_badge->getURL(),
			"wgLogo" 		=> $wgLogo,
			"wgSitename"	=> $wgSitename,
			"sk"			=> $sk,
		) );

		$html .= $oTmpl->execute("pref-badge-form");

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * getLocalPath -- create file path from user identifier
	 */
	public function getLocalPath() {
		wfProfileIn( __METHOD__ );

		if( $this->mPath ) {
			wfProfileOut( __METHOD__ );
			return $this->mPath;
		}

		$image  = sprintf("%s.png", $this->mUser->getID() );
		$hash   = sha1( (string)$this->mUser->getID() );
		$folder = substr( $hash, 0, 1)."/".substr( $hash, 0, 2 );

		$this->mPath = "/{$folder}/{$image}";

		wfProfileOut( __METHOD__ );

		return $this->mPath;
	}
	
	/**
	 * getFullPath -- return full path for image
	 */
	public function getFullPath() {
		global $wgUserBadgesDirectory;
		return $wgUserBadgesDirectory.$this->getLocalPath();
	}
	
	/**
	 * getUrl -- read url from preferences or from defaults if preference is
	 * not set.
	 *
	 * @access private
	 *
	 * @return String
	 */
	public function getUrl() {
		global $wgUserBadgesPath;
		wfProfileIn( __METHOD__ );
		$sBadges = $this->mUser->getOption( USER_BADGES_OPTION_NAME );
		$sUrl = "";
		error_log ("sBadges = " . print_r($sBadges, true));
		if (!empty($sBadges)) {
			$this->mOptions = @unserialize($sBadges);
			if ( !empty($this->mOptions[$this->mCity]) && 
				($this->mOptions[$this->mCity] instanceof UserBadgesOptions ) 
			) {
				$sUrl = $this->mOptions[$this->mCity]->getUrl();
				if( strpos( $sUrl, "/" ) !== false ) {
					$sUrl = $wgUserBadgesPath . $sUrl . "?" . $this->mUser->mTouched;
				} else {
					$uploadPath = rtrim( WikiFactory::getVarValueByName( "wgUploadPath", $this->mMsgCityId ), "/" ) . "/";
					$hash = FileRepo::getHashPathForLevel( $sUrl, 2 );
					$sUrl = $uploadPath . $hash . $sUrl;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return (!empty($sUrl)) ? wfReplaceImageServer( $url ) : "";
	}
	
	/**
	 * savePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param User $User -- user object
	 * @param String $sMsg -- status message
	 * @param $oldOptions
	 */
	static public function savePreferences( $oPrefs, $mUser, &$sMsg, $oldOptions ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$result = true;
		
		// to do 
		
		wfProfileOut( __METHOD__ );
		return $result;
	}
	
}


class UserBadgesOptions {
	var $mCity;
	var $mBackColor;
	var $mWikiaColor;
	var $mTextColor;
	var $mLinkColor;
	var $mWikiaLogoColor;
	var $mUrl;
	
	function getCity() { return $this->mCity; }
	function setCity($city) { $this->mCity = $city; }
	
	function getBackColor() { return $this->mBackColor; }
	function setBackColor($color) { $this->mBackColor = $color; }

	function getWikiaColor() { return $this->mWikiaColor; }
	function setWikiaColor($color) { $this->mWikiaColor = $color; }

	function getTextColor() { return $this->mTextColor; }
	function setTextColor($color) { $this->mTextColor = $color; }

	function getLinkColor() { return $this->mLinkColor; }
	function setLinkColor($color) { $this->mLinkColor = $color; }

	function getWikiaLogoColor() { return $this->mWikiaLogoColor; }
	function setWikiaLogoColor($color) { $this->mWikiaLogoColor = $color; }

	function getUrl() { return $this->mUrl; }
	function setUrl($url) { $this->mUrl = $url; }
}
