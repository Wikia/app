<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named User Badges.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "User Badges",
    "description" => "Generate user badges",
    "author" => "Piotr Molski"
);

define ("USER_BADGES_OPTION_NAME", 'userbadges');
define ("USER_BADGES_DIR_NAME", 'badges');
define ("USER_BADGES_WIDTH", '300');
define ("USER_BADGES_HEIGHT", '90');
define ("USER_BADGES_HEADER_HEIGHT", '20');
define ("USER_BADGES_HEADER_MARGIN", '5');
define ("USER_BADGES_BODY_MARGIN", '5');
define ("USER_BADGES_FONT_PATH", "extensions/wikia/Badges/fonts");
define ("USER_BADGES_LOGO_WIDTH", '80');
define ("USER_BADGES_LOGO_HEIGHT", '80');
define ("USER_BADGES_SMALL_LOGO_WIDTH", '56');
define ("USER_BADGES_SMALL_LOGO_HEIGHT", '15');
define ("USER_BADGES_TAG", "badge");

$wgExtensionMessagesFiles["UserBadges"] = dirname(__FILE__) . '/UserBadges.i18n.php';

$wgExtensionFunctions[] = array("UserBadges", "setup");

#$wgHooks['AdditionalUserProfilePreferences'][] = "UserBadges::addPreferences";
$wgHooks['RenderPreferencesForm'][] = "UserBadges::addPreferences";
$wgHooks['SavePreferences'][] = "UserBadges::savePreferences";

# use <badge> as internal tag
$wgHooks['LanguageGetMagic'][] = "UserBadges::setMagicWord";

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
	 * unserialized options
	 */
	public $mOptions = array();

	/**
	 * unserialized options
	 */
	public $mCurrentOptions = null;

	/**
	 * default options
	 */
	public $mDefOptions = array();
	
	public function __construct( User $User ) {
		global $wgCityId, $wgStylePath;
		wfProfileIn( __METHOD__ );
		$this->mUser = $User;
		$this->mCity = $wgCityId;
		wfLoadExtensionMessages("UserBadges");

		$this->mOptions = $this->getUserOptions();
		$this->mPath = $this->getImagePath();
		
		$this->mDefOptions = array (
			'body-logo' => array(
				'left' => array('value' => '-15px auto 0 5px', 'text' => wfMsg('user-badge-left-align'), 'default' => 1),
				'right' => array('value' => '-15px 5px 0 auto', 'text' => wfMsg('user-badge-right-align')),
			),
			'body-small-logo' => array(
				'left' => array('value' => '-20px auto 0 0', 'text' => wfMsg('user-badge-left-align')),
				'right' => array('value' => '-20px 0 0 auto', 'text' => wfMsg('user-badge-right-align'), 'default' => 1),
			),
			'small-logo-color' => array(
				'blue' => "/monaco/images/wikia_logo.png",
				'yellow' => "/monaco/smoke/images/wikia_logo.png",
				'black' => "/monaco/images/wikia_logo_black.png",
				'green' => "/monaco/jade/images/wikia_logo.png",
			)
		);
		
		$this->setDefaultOptions();
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
	static public function addPreferences( &$oPrefs, $oOut) {
		global $wgUser, $wgOut;
		global $wgStyleVersion, $wgExtensionsPath;
		global $wgLogo, $wgSitename;
		global $wgStylePath, $wgServer, $wgLang;
		
		wfProfileIn( __METHOD__ );
		$User_badge = self::newFromUser( $wgUser );
		$sk = $wgUser->getSkin();
		/**
		 * run template
		 */
		
		$oOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/yui_2.5.2/colorpicker/assets/skins/sam/colorpicker.css?{$wgStyleVersion}\" />" );
		$oOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/Badges/css/UserBadges.css?{$wgStyleVersion}\" />" );
		$oOut->addScript( "<script type=\"text/javascript\" src=\"/skins/common/yui_2.5.2/slider/slider-min.js?{$wgStyleVersion}\"></script>" );
		$oOut->addScript( "<script type=\"text/javascript\" src=\"/skins/common/yui_2.5.2/colorpicker/colorpicker-min.js?{$wgStyleVersion}\"></script> ");
		$oOut->addScript( "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/Badges/js/UserBadges.js?{$wgStyleVersion}\"></script>");
		
		$oOut->addHtml( '<fieldset><legend>' . wfMsgHtml( 'user-badge-title' ) . '</legend>' );
		
		$domain = str_replace("http://", "", $wgServer);
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser"		=> $wgUser,
			"cityId"		=> $User_badge->mCity,
			"domain"		=> $domain,
			"oUserBadge"	=> $User_badge,
			"sUserBadgeImg" => $User_badge->getFullUrl(1),
			"sUserBadgeUrl" => $User_badge->getFullUrl(0),
			"wgLogo" 		=> $wgLogo,
			"wgSitename"	=> $wgSitename,
			"defOptions"	=> $User_badge->mDefOptions,
			"sk"			=> $sk,
			"wgLang"		=> $wgLang,
			"wgStylePath"	=> $wgStylePath,
			"wgServer"		=> $wgServer,
			"mCurrentOptions" => $User_badge->mCurrentOptions,
		) );
		$oOut->addHtml($oTmpl->execute("pref-badge-form"));
		$oOut->addHtml( '</fieldset>' );

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * getLocalPath -- create file path from user identifier
	 */
	public function getLocalPath() {
		wfProfileIn( __METHOD__ );
		$image  = sprintf("%s.png", $this->mUser->getID() );
		$hash   = sha1( (string)$this->mUser->getID() );
		$folder = substr( $hash, 0, 1)."/".substr( $hash, 0, 2 );

		$this->mPath = "/" . USER_BADGES_DIR_NAME . "/{$folder}/{$image}";
		wfProfileOut( __METHOD__ );
		return $this->mPath;
	}
	
	/**
	 * getFullPath -- return full path for image
	 */
	public function getFullPath() {
		global $wgUploadDirectory;
		return $wgUploadDirectory . $this->getLocalPath();
	}
	
	/**
	 * setup function to parse <badge> tag
	 *
	 * @access public
	 *
	 * @return 
	 */
	public static function setup() {
		global $wgParser, $wgMessageCache;
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );
		$wgParser->setHook( USER_BADGES_TAG, array( __CLASS__, "parseTag" ) );
		wfLoadExtensionMessages("UserBadges");
		wfProfileOut( __METHOD__ );
	}

	/**
	 * setMagicWord
	 *
	 * @access public
	 *
	 * @return true
	 */
	public static function setMagicWord( &$magicWords, $langCode ) {
		wfProfileIn( __METHOD__ );
		/* add the magic word */
		$magicWords[USER_BADGES_TAG] = array( 0, USER_BADGES_TAG );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function parseTag( $input, $params, &$parser ) {
		global $wgUser, $wgCityId, $wgServer;
		wfProfileIn( __METHOD__ );
		/* parse input parameters */
		$res = "";
		wfDebugLog( __METHOD__, "parse input parameters\n" );
		$oUser = (isset($params['user'])) ? User::newFromName($params['user']) : null;
		if (!empty($oUser)) {
			$User_badge = self::newFromUser( $oUser );
			if (isset($params['wikia'])) {
				$User_badge->mCity = WikiFactory::VarValueToID("http://".$params['wikia']);
			} else {
				$User_badge->mCity = $wgCityId;
			}
			$badgeUrl = $User_badge->getFullUrl();
			if (!empty($badgeUrl)) {
				$res = 	"<a href=\"{$wgServer}\"><img src=\"{$badgeUrl}\" border=\"0\" /></a>";
			}
		} 
		wfProfileOut( __METHOD__ );
		return $res;
	}
	
	/**
	 * getUserOptions -- read badges from preferences 
	 *
	 * @access private
	 *
	 * @return String
	 */
	private function getUserOptions() {
		wfProfileIn( __METHOD__ );
		$sBadges = $this->mUser->getOption( USER_BADGES_OPTION_NAME );
		$aOptions = array();
		if (!empty($sBadges)) {
			$aOptions = @unserialize($sBadges);
		}
		wfProfileOut( __METHOD__ );
		return $aOptions;
	}

	/**
	 * getImagePath -- read url from preferences 
	 *
	 * @access private
	 *
	 * @return String
	 */
	private function getImagePath() {
		global $wgUploadDirectory;
		wfProfileIn( __METHOD__ );
		$sPath = "";
		if ( !empty($this->mOptions[$this->mCity]) && 
			($this->mOptions[$this->mCity] instanceof UserBadgesOptions ) 
		) {
			$sUrl = $this->mOptions[$this->mCity]->getUrl();
			if( strpos( $sUrl, "/" ) !== false ) {
				$sPath = $wgUploadDirectory . $sUrl;
			} else {
				$uploadPath = rtrim( WikiFactory::getVarValueByName( "wgUploadPath", $this->mMsgCityId ), "/" ) . "/";
				$hash = FileRepo::getHashPathForLevel( $sUrl, 2 );
				$sPath = $uploadPath . $hash . $sUrl;
			}
		}
		wfProfileOut( __METHOD__ );
		return $sPath;
	}
	
	/**
	 * getUrl -- read url from preferences 
	 *
	 * @access private
	 *
	 * @return String
	 */
	public function getFullUrl($touched = 0) {
		global $wgUploadPath;
		$url = "";
		if ( !empty($this->mCurrentOptions) && ($this->mCurrentOptions instanceof UserBadgesOptions) ) {
			$url = $this->mCurrentOptions->getUrl();
			if( !empty($url) ) {
				/**
				 * if default avatar we glue with messaging.wikia.com
				 * if uploaded avatar we glue with common avatar path
				 */
				if( strpos( $url, "/" ) !== false ) {
					/**
					 * uploaded file, we are adding common/avatars path
					 */
					$url = $wgUploadPath . $url;
					if (!empty($touched)) {
						$url = $url . "?" . $this->mUser->mTouched;
					}
				} else {
					/**
					 * default avatar, path from messaging.wikia.com
					 */
					$uploadPath = rtrim( WikiFactory::getVarValueByName( "wgUploadPath", $this->mMsgCityId ), "/" ) . "/";
					$hash = FileRepo::getHashPathForLevel( $url, 2 );
					$url = $uploadPath . $hash . $url;
				}
			} else {
				$url = "";
			}
		}
		return $url ? wfReplaceImageServer( $url ) : "";
	}
	
	
	private function setDefaultOptions() {
		if (!empty($this->mOptions) && is_array($this->mOptions) && isset($this->mOptions[$this->mCity])) {
			$oUserBadgesOptions = $this->mOptions[$this->mCity];
			if ( !empty($oUserBadgesOptions) && (is_object($oUserBadgesOptions)) ) {
				$this->mCurrentOptions = $oUserBadgesOptions;
				$sLogoAlign = $oUserBadgesOptions->getBodyLogoAlign();
				if (isset($this->mDefOptions['body-logo'][$sLogoAlign])) {
					foreach ($this->mDefOptions['body-logo'] as $id => $value) {
						$this->mDefOptions['body-logo'][$id]['default'] = 0;
					}
					$this->mDefOptions['body-logo'][$sLogoAlign]['default'] = 1;
				}
				$sSmallLogoAlign = $oUserBadgesOptions->getBodySmallLogoAlign();
				if (isset($this->mDefOptions['body-small-logo'][$sSmallLogoAlign])) {
					foreach ($this->mDefOptions['body-small-logo'] as $id => $value) {
						$this->mDefOptions['body-small-logo'][$id]['default'] = 0;
					}
					$this->mDefOptions['body-small-logo'][$sSmallLogoAlign]['default'] = 1;
				}
			} 
		}
		if ( !($this->mCurrentOptions instanceof UserBadgesOptions) ) {
			$this->mCurrentOptions = new UserBadgesOptions();
		}
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
		global $wgRequest, $wgCityId;
		wfProfileIn( __METHOD__ );
		$result = true;
		
		// to do 
		$isEnableCreate = $wgRequest->getCheck( 'ub-overwrite-badge' );

		if ( !empty($isEnableCreate) ) {
			$User_badge = self::newFromUser( $mUser );
			$oBadgeOptions = new UserBadgesOptions();

			$oBadgeOptions->setCity($wgCityId);
			$oBadgeOptions->setHeaderBgColor( $wgRequest->getVal( 'ub-header-bg-color' ) );
			$oBadgeOptions->setHeaderTxtColor( $wgRequest->getVal( 'ub-header-txt-color' ) );
			$oBadgeOptions->setHeaderTxtAlign( $wgRequest->getVal( 'ub-header-txt-align' ) );
			
			$oBadgeOptions->setBodyBgColor( $wgRequest->getVal( 'ub-body-bg-color' ) );
			$oBadgeOptions->setBodyLabelColor( $wgRequest->getVal( 'ub-body-label-color' ) );
			$oBadgeOptions->setBodyDataColor( $wgRequest->getVal( 'ub-body-data-color' ) );
			
			$oBadgeOptions->setSmallLogoColor( $wgRequest->getVal( 'ub-body-small-logo-color' ) );
			
			$logoAlign = $wgRequest->getVal( 'ub-body-logo-align' );
			if (!empty($logoAlign)) {
				if ($User_badge->mDefOptions['body-logo']) {
					foreach ($User_badge->mDefOptions['body-logo'] as $align => $values) {
						if ( $values['value'] == $logoAlign ) {
							$oBadgeOptions->setBodyLogoAlign( $align );
							break;
						}
					}
				}
			}
		
			$smallLogoAlign = $wgRequest->getVal( 'ub-body-small-logo-align' );
			if (!empty($smallLogoAlign)) {
				if ($User_badge->mDefOptions['body-small-logo']) {
					foreach ($User_badge->mDefOptions['body-small-logo'] as $align => $values) {
						if ( $values['value'] == $smallLogoAlign ) {
							$oBadgeOptions->setBodySmallLogoAlign( $align );
							break;
						}
					}
				}
			}
			
			$pathImage = $User_badge->createImage($oBadgeOptions, $mUser);
			if (!empty($pathImage)) {
				// set path to image
				$oBadgeOptions->setUrl($pathImage);				
				if ( empty($User_badge->mOptions) ) {
					$User_badge->mOptions = array();
				}
				$User_badge->mOptions[$User_badge->mCity] = $oBadgeOptions;
				$saveValue = @serialize($User_badge->mOptions);
				$mUser->setOption( USER_BADGES_OPTION_NAME, $saveValue );
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}	
	
	/**
	 * getRGBColor -- return RGB color
	 *
	 * @param String $color  -- color 
	 */
    private static function getRGBColor($color) {
    	wfProfileIn( __METHOD__ );
    	$aRGBColor = array(0, 0, 0);
    	
        if (!empty($color)) {
        	if ( (count($color) == 3) && is_array($color) ) {
        		$aRGBColor = $color;
        	} elseif ($color[0] == '#') { 
        		$aRGBColor = array(
        			hexdec(substr($color, 1, 2)),
        			hexdec(substr($color, 3, 2)),
        			hexdec(substr($color, 5, 2))
        		);
        	} else {
            	Wikia::log(__METHOD__, "invalid color", "Color '$color' is not valid.");
			}
        }
        wfProfileOut( __METHOD__ );
        return $aRGBColor;
    }

	/**
	 * savePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param User $User -- user object
	 * @param String $sMsg -- status message
	 * @param $oldOptions
	 */
	private function createImage($options, $mUser) {
		global $wgExtensionsPath;
		global $wgSitename, $wgLogo, $wgLang;
		global $wgStyleDirectory, $wgUploadDirectory;
		wfProfileIn( __METHOD__ );
		$sPath = "";

		// font path
		$fontArial = USER_BADGES_FONT_PATH . "/DejaVuSansCondensed.ttf"; #"/arial.ttf";
		$fontArialBold = USER_BADGES_FONT_PATH . "/DejaVuSansCondensed-Bold.ttf"; #"/arial_bold.ttf";
		$fontVerdana = USER_BADGES_FONT_PATH . "/DejaVuSans.ttf"; # "/verdana.ttf";
		$fontVerdanaBold = USER_BADGES_FONT_PATH . "/DejaVuSans-Bold.ttf"; #"/verdana_bold.ttf";

		$image = imagecreatetruecolor(USER_BADGES_WIDTH, USER_BADGES_HEIGHT) or Wikia::log(__METHOD__, "PHP:GD", "Cannot Initialize new GD image stream");
		if ($image) {
			// Create some colors
			/*
			 * header
			 */
			// font size
			$header = array('fontsize' => 10);
			// background color
			list ( $r, $g, $b ) = $this->getRGBColor($options->getHeaderBgColor());
			$header['bgcolor'] = imagecolorallocate($image, $r, $g, $b);
			// text color
			list ( $r, $g, $b ) = $this->getRGBColor($options->getHeaderTxtColor());
			$header['txtcolor'] = imagecolorallocate($image, $r, $g, $b);
			// header text 
			$header['text'] = $wgSitename;
			// align
			$header['align'] = $options->getHeaderTxtAlign();
			$header['x'] = USER_BADGES_HEADER_MARGIN; 
			$header['y'] = $header['fontsize'] + USER_BADGES_HEADER_MARGIN;
			switch ($header['align']) {
				case 'left' : {
					$header['x'] = USER_BADGES_HEADER_MARGIN;
					break;
				}
				case 'center' : {
					$headerBox = imagettfbbox($header['fontsize'], 0, $fontVerdanaBold, $header['text']);
					$header['x'] = ceil( (USER_BADGES_WIDTH - $headerBox[2])/2 );
					break;
				}
				default : {
					$headerBox = imagettfbbox($header['fontsize'], 0, $fontVerdanaBold, $header['text']);
					$header['x'] = ceil( (USER_BADGES_WIDTH - $headerBox[2] - USER_BADGES_HEADER_MARGIN) );
					break;
				}
			}
			// body
			$oLogo = wfLocalFile( Title::newFromtext( "Wiki.png", NS_IMAGE ) );
			$sLogo = $wgLogo;
			if ( !empty($oLogo) && file_exists($oLogo->getPath()) ) { 
				$sLogo = $oLogo->getPath();
			} 
			$body = array(
				'labelfontsize' => 10, 
				'logo' =>  $sLogo,
				'datafontsize' => 12,
				'smalllogo' => $wgStyleDirectory . $this->mDefOptions['small-logo-color']['yellow'],
			);
			// small logo
			$smallLogo = $options->getSmallLogoColor();
			if (!empty($smallLogo) && isset($this->mDefOptions['small-logo-color'][$smallLogo])) {
				$body['smalllogo'] = $wgStyleDirectory . $this->mDefOptions['small-logo-color'][$smallLogo];
			} 
			list ( $r, $g, $b ) = $this->getRGBColor($options->getBodyBgColor());
			$body['bgcolor'] = imagecolorallocate($image, $r, $g, $b);
			list ( $r, $g, $b ) = $this->getRGBColor($options->getBodyLabelColor());
			$body['labelcolor'] = imagecolorallocate($image, $r, $g, $b);
			list ( $r, $g, $b ) = $this->getRGBColor($options->getBodyDataColor());
			$body['datacolor'] = imagecolorallocate($image, $r, $g, $b);
			// logo 
			$aBodyLogo = $this->createImageFromPath($body['logo']);
			if (empty($aBodyLogo)) {
				wfProfileOut( __METHOD__ );
				return false;				
			}
			list ($oBodyLogo, $body['logoOrygWidth'], $body['logoOrygHeight']) = $aBodyLogo;
			// logo align
			$body['logoalign'] = $options->getBodyLogoAlign();
			$body['logoWidth'] = USER_BADGES_LOGO_WIDTH; 
			$body['logoHeight'] = USER_BADGES_LOGO_HEIGHT;
			switch ($body['logoalign']) {
				case 'right' : {
					$body['logoDstX'] = USER_BADGES_WIDTH - USER_BADGES_LOGO_WIDTH - USER_BADGES_BODY_MARGIN;
					$body['logoDstY'] = USER_BADGES_HEIGHT - USER_BADGES_LOGO_HEIGHT - USER_BADGES_BODY_MARGIN;
					break;
				}
				default : {
					$body['logoDstX'] = $body['logoDstY'] = USER_BADGES_BODY_MARGIN;
					break;
				}			
			} 
			// label Username 
			$body['labelUsernameText'] = str_replace(":", "", wfMsg('username'));
			$body['labelUsernameX'] = USER_BADGES_LOGO_WIDTH + 2 * (USER_BADGES_BODY_MARGIN); 
			$body['labelUsernameY'] = $body['labelfontsize'] + USER_BADGES_HEADER_HEIGHT + 1;
			
			// data username 
			$body['dataUsernameText'] = $mUser->getName();
			$body['dataUsernameX'] = USER_BADGES_LOGO_WIDTH + 2 * (USER_BADGES_BODY_MARGIN); 
			$body['dataUsernameY'] = $body['labelUsernameY'] + $body['datafontsize'] + ceil(USER_BADGES_BODY_MARGIN/2);

			// label Edits
			$body['labelEditsText'] = wfMsg('user-badge-edits-txt');
			$body['labelEditsX'] = USER_BADGES_LOGO_WIDTH + 2 * (USER_BADGES_BODY_MARGIN); 
			$body['labelEditsY'] = $body['dataUsernameY'] + (2 * intval($body['labelfontsize']));
			
			// data Edits
			$body['dataEditsText'] = self::getEditCount($mUser->getId());
			$body['dataEditsX'] = USER_BADGES_LOGO_WIDTH + 2 * (USER_BADGES_BODY_MARGIN); 
			$body['dataEditsY'] = $body['labelEditsY'] + $body['datafontsize'] + ceil(USER_BADGES_BODY_MARGIN/2);

			// small logo 
			$aSmallBodyLogo = $this->createImageFromPath($body['smalllogo']);
			if (empty($aSmallBodyLogo)) {
				wfProfileOut( __METHOD__ );
				return false;				
			}
			list ($oSmallBodyLogo, $body['smalllogoOrygWidth'], $body['smalllogoOrygHeight']) = $aSmallBodyLogo;
			// small logo align
			$body['smalllogoalign'] = $options->getBodySmallLogoAlign();
			$body['smalllogoWidth'] = USER_BADGES_SMALL_LOGO_WIDTH; 
			$body['smalllogoHeight'] = USER_BADGES_SMALL_LOGO_HEIGHT;
			switch ($body['smalllogoalign']) {
				case 'left' : {
					$body['smalllogoDstX'] = USER_BADGES_BODY_MARGIN;
					$body['smalllogoDstY'] = USER_BADGES_HEIGHT - USER_BADGES_SMALL_LOGO_HEIGHT - USER_BADGES_BODY_MARGIN;
					break;
				}
				default : {
					$body['smalllogoDstX'] = USER_BADGES_WIDTH - USER_BADGES_SMALL_LOGO_WIDTH - USER_BADGES_BODY_MARGIN;
					$body['smalllogoDstY'] = USER_BADGES_HEIGHT - USER_BADGES_SMALL_LOGO_HEIGHT - USER_BADGES_BODY_MARGIN;
					break;
				}			
			} 
			/*
			 * create image
			 */ 
			// image background 
			@imagefilledrectangle($image, 0, 0, USER_BADGES_WIDTH, USER_BADGES_HEIGHT, $header['bgcolor']);
			// colorize body
			@imagefilledrectangle($image, 1, USER_BADGES_HEADER_HEIGHT, USER_BADGES_WIDTH - 2, USER_BADGES_HEIGHT - 2, $body['bgcolor']);
			// header text
			@imagettftext( $image, $header['fontsize'], 0 /* angle */, $header['x'], $header['y'], $header['txtcolor'], $fontVerdanaBold, $header['text'] );
			// Wikia logo 
			@imagecopyresized( $image, 
				$oBodyLogo, 
				$body['logoDstX'], 
				$body['logoDstY'], 
				0, 
				0, 
				$body['logoWidth'], 
				$body['logoHeight'], 
				$body['logoOrygWidth'], 
				$body['logoOrygHeight']
			);
			// label <USERNAME>
			@imagettftext( $image, $body['labelfontsize'], 0 /* angle */, $body['labelUsernameX'], $body['labelUsernameY'], $body['labelcolor'], $fontVerdanaBold, $body['labelUsernameText'] );
			// data <USERNAME>
			@imagettftext( $image, $body['datafontsize'], 0 /* angle */, $body['dataUsernameX'], $body['dataUsernameY'], $body['datacolor'], $fontArial, $body['dataUsernameText'] );
			// label <EDITS>
			@imagettftext( $image, $body['labelfontsize'], 0 /* angle */, $body['labelEditsX'], $body['labelEditsY'], $body['labelcolor'], $fontVerdanaBold, $body['labelEditsText'] );
			// data <EDITS>
			@imagettftext( $image, $body['datafontsize'], 0 /* angle */, $body['dataEditsX'], $body['dataEditsY'], $body['datacolor'], $fontArial, $body['dataEditsText'] );
			// small Wikia logo 
			@imagecopyresized( $image, 
				$oSmallBodyLogo, 
				$body['smalllogoDstX'], 
				$body['smalllogoDstY'], 
				0, 
				0, 
				$body['smalllogoWidth'], 
				$body['smalllogoHeight'], 
				$body['smalllogoOrygWidth'], 
				$body['smalllogoOrygHeight']
			);
			$sFilePath = $this->getFullPath();
			if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {
				Wikia::log( __METHOD__, "dir", sprintf("Cannot create directory %s", dirname( $sFilePath ) ) );
				wfProfileOut( __METHOD__ );
				return false;
			} 
			imagepng($image, $sFilePath);
			@imagedestroy($image);		
			$sPath = $this->getLocalPath();
		}

		wfProfileOut( __METHOD__ );
		return $sPath; 
	}
	
	private function createImageFromPath($path) {
		wfProfileIn(__METHOD__);
		$aImgInfo = getimagesize($path);
		$aAllowMime = array( "image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", "image/bmp" );
		if (!in_array($aImgInfo["mime"], $aAllowMime)) {
			Wikia::log( __METHOD__, "mime", "Imvalid mime type, allowed: " . implode(",", $aAllowMime) );
			wfProfileOut(__METHOD__);
			return false;
		}

		switch ($aImgInfo["mime"]) {
			case "image/gif":
				$oImgOrig = @imagecreatefromgif($path);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$oImgOrig = @imagecreatefromjpeg($path);
				break;
			case "image/bmp":
				$oImgOrig = @imagecreatefrombmp($path);
				break;
			case "image/x-png":
			case "image/png":
				$oImgOrig = @imagecreatefrompng($path);
				break;
		}
		wfProfileOut(__METHOD__);
		return array($oImgOrig, $aImgInfo[0], $aImgInfo[1]);
	}
	
	public static function getEditCount($uid) {
		global $wgContLang, $wgCityId, $wgStatsDB;
		wfProfileIn(__METHOD__);
		
		$editCount = 0;
		if (class_exists("Editcount")) {
			$editCount = $wgContLang->formatNum( Editcount::getTotal( Editcount::editsByNs( $uid ) ) );
		} else {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$res = $dbs->select(
				array( '`specials`.`events_local_users`' ),
				array( 'count(*) as cnt' ),
				array(
					'wiki_id' => $wgCityId,
					'user_id' => $uid
				),
				$fname
			);
			if ( $row = $dbs->fetchObject( $res ) ) { 
				$editCount = $row->cnt;
			}
		}
		
		wfProfileOut(__METHOD__);
		return $editCount;
	}
	
}

class UserBadgesOptions {
	var $mCity;
	var $mHeaderBgColor;
	var $mHeaderTxtColor;
	var $mHeaderTxtAlign = "right";

	var $mBodyBgColor;
	var $mBodyLabelColor;
	var $mBodyDataColor;
	var $mBodyLogoAlign = "left";
	var $mBodySmallLogoAlign = "right";
	var $mBodySmallLogoColor = "yellow";
	
	var $mUrl;
	
	function getCity() { return $this->mCity; }
	function setCity($city) { $this->mCity = $city; }
	
	function getHeaderBgColor() { return $this->mHeaderBgColor; }
	function setHeaderBgColor($color) { $this->mHeaderBgColor = $color; }

	function getHeaderTxtColor() { return $this->mHeaderTxtColor; }
	function setHeaderTxtColor($color) { $this->mHeaderTxtColor = $color; }

	function getHeaderTxtAlign() { return $this->mHeaderTxtAlign; }
	function setHeaderTxtAlign($align) { $this->mHeaderTxtAlign = $align; }

	function getBodyBgColor() { return $this->mBodyBgColor; }
	function setBodyBgColor($color) { $this->mBodyBgColor = $color; }

	function getBodyLabelColor() { return $this->mBodyLabelColor; }
	function setBodyLabelColor($color) { $this->mBodyLabelColor = $color; }

	function getBodyDataColor() { return $this->mBodyDataColor; }
	function setBodyDataColor($color) { $this->mBodyDataColor = $color; }

	function getBodyLogoAlign() { return $this->mBodyLogoAlign; }
	function setBodyLogoAlign($align) { $this->mBodyLogoAlign = $align; }

	function getBodySmallLogoAlign() { return $this->mBodySmallLogoAlign; }
	function setBodySmallLogoAlign($align) { $this->mBodySmallLogoAlign = $align; }

	function getSmallLogoColor() { return $this->mBodySmallLogoColor; }
	function setSmallLogoColor($color) { $this->mBodySmallLogoColor = $color; }

	function getUrl() { return $this->mUrl; }
	function setUrl($url) { $this->mUrl = $url; }
}
