<?php
/**
 * CreateWiki class
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia Inc.
 * @author Adrian Wieczorek <adi@wikia-inc.com> for Wikia Inc.
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia Inc.
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

class CreateWiki {

	private $mName, $mDomain, $mLanguage, $mHub, $mType, $mStarters,
		$mPHPbin, $mMYSQLbin, $mMYSQLdump, $mWikiData;

	const ERROR_BAD_EXECUTABLE_PATH      = 1;
	const ERROR_DOMAIN_NAME_TAKEN        = 2;
	const ERROR_DOMAIN_BAD_NAME          = 3;
	const ERROR_DOMAIN_IS_EMPTY          = 4;
	const ERROR_DOMAIN_TOO_LONG          = 5;
	const ERROR_DOMAIN_TOO_SHORT	     = 6;
	const ERROR_DOMAIN_POLICY_VIOLATIONS = 7;


	const IMGROOT           = "/images/";
	const IMAGEURL          = "http://images.wikia.com/";
	const CREATEWIKI_LOGO   = "/images/c/central/images/2/22/Wiki_Logo_Template.png";
	const CREATEWIKI_ICON   = "/images/c/central/images/6/64/Favicon.ico";
	const DEFAULT_STAFF     = "Angela";
	const DEFAULT_USER      = 'Default';
	const DEFAULT_DOMAIN    = "wikia.com";
	const ACTIVE_CLUSTER    = "c3";
	const DEFAULT_NAME      = "Wiki";
	const DEFAULT_WIKI_TYPE = "default";


	/**
	 * constructor
	 *
	 * @param string $name - name of wiki (set later as $wgSiteinfo)
	 * @param string $domain - domain part without '.wikia.com'
	 * @param string $language - language code
	 * @param integer $hub - category/hub which should be set for created wiki
	 * @param mixed $type - type of wiki, currently 'answers' for answers or false for others
	 */
	public function __construct( $name, $domain, $language, $hub, $type = self::DEFAULT_WIKI_TYPE  ) {
		$this->mDomain = $domain;
		$this->mName = $name;
		$this->mLanguage = $language;
		$this->mHub = $hub;
		$this->mType = $type;

		/**
		 * starters map: langcode => database name
		 *
		 * "*" is default
		 * "answers" when $mType = "answers"
		 */
		$this->mStarters = array(
			"*" => array(
				"*"  => "aastarter",
				"en" => "starter",
				"ja" => "jastarter",
				"de" => "destarter",
				"fr" => "frstarter",
				"nl" => "nlstarter",
				"es" => "esstarter",
				"pl" => "plstarter"
			),
			"answers" => array(
				"*"  => "genericstarteranswers",
				"en" => "newstarteranswers",
				"de" => "deuanswers",
				"es" => "esstarteranswers",
				"fr" => "frstarteranswers",
				"he" => "hestarteranswers",
				"ar" => "arstarteranswers",
				"nl" => "nlstarteranswers",
			)
		);
	}


	/**
	 * main entry point, create wiki with given parameters
	 *
	 * @return integer status of operation, 0 for success, non 0 for error
	 */
	public function create() {

		wfProfileIn( __METHOD__ );

		/**
		 * check executables
		 */
		$status = $this->checkExecutables();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			return $status;
		}

		/**
		 * check domain name
		 */
		$status = $this->checkDomain();
		if( $status != 0 ) {
			wfProfileOut( __METHOD__ );
			return 0;
		}

		/**
		 * prepare all values needed for creating wiki
		 */
		$newWikia = $this->prepareValues( $this->mDomain, $this->mLanguage, $this->mType );

		wfProfileOut( __METHOD__ );

		/**
		 * return success
		 */
		return 0;
	}


	/**
	 * check for executables needed for creating wiki
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return integer status of check, 0 for success, non 0 otherwise
	 */
	private function checkExecutables( ) {
		/**
		 * set paths for external tools
		 */
		$this->mPHPbin = "/usr/bin/php";
		if( !file_exists( $this->mPHPbin ) && !is_executable( $this->mPHPbin ) ) {
			wfDebug( __METHOD__ . ": {$this->mPHPbin} doesn't exists or is not executable\n" );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}

		$this->mMYSQLdump = "/usr/bin/mysqldump";
		if( !file_exists( $this->mMYSQLdump ) && !is_executable( $this->mMYSQLdump ) ) {
			wfDebug( __METHOD__ . ": {$this->mMYSQLdump} doesn't exists or is not executable\n" );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}

		$this->mMYSQLbin = "/usr/bin/mysql";
		if( !file_exists( $this->mMYSQLbin ) && !is_executable( $this->mMYSQLbin ) ) {
			wfDebug( __METHOD__ . ": {$this->mMYSQLbin} doesn't exists or is not executable\n" );
			return self::ERROR_BAD_EXECUTABLE_PATH;
		}
		return 0;
	}

	/**
	 * check if domain is not taken or is creatable
	 */
	private function checkDomain() {

		global $wgUser;

		$status = 0;

		wfProfileIn(__METHOD__);

		if( strlen( $this->mDomain ) === 0 ) {
			// empty field
			$status = self::ERROR_DOMAIN_IS_EMPTY;
		}
		elseif ( strlen( $this->mDomain ) < 3 ) {
			// too short
			$status = self::ERROR_DOMAIN_TOO_SHORT;
		}
		elseif ( strlen( $this->mDomain ) > 50 ) {
			// too long
			$status = self::ERROR_DOMAIN_TOO_LONG;
		}
		elseif (preg_match('/[^a-z0-9-]/i', $this->mDomain ) ) {
			// invalid name
			$status = self::ERROR_DOMAIN_BAD_NAME;
		}
		elseif ( in_array( $this->mDomain, array_keys( Language::getLanguageNames() ) ) ) {
			// invalid name (name is used language)
			$status = self::ERROR_DOMAIN_POLICY_VIOLATIONS;
		}
		elseif ( !$wgUser->isAllowed( "staff" ) && ( AutoCreateWiki::checkBadWords( $this->mDomain, "domain" ) === false ) ) {
			// invalid name (bad words)
			$status = self::ERROR_DOMAIN_POLICY_VIOLATIONS;
		}
		else {
			if( AutoCreateWiki::domainExists( $this->mDomain, $this->mLanguage, $this->mType ) ) {
				$status = self::ERROR_DOMAIN_NAME_TAKEN;
			}
		}

		return 0;
	}

	/**
	 * prepare default values
	 *
	 * @access private
	 *
	 * @author Piotr Molski
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @param
	 */
	private function prepareValues() {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$this->fixSubdomains( $this->mLanguage );

		// founder
		$result = array();
		$result[ "founder" ] = $wgUser;

		// sitename
		$fixedTitle = trim( $this->mName );
		$fixedTitle = preg_replace("/\s+/", " ", $fixedTitle );
		$fixedTitle = preg_replace("/ (w|W)iki$/", "", $fixedTitle );
		$fixedTitle = $wgContLang->ucfirst( $fixedTitle );
		$result[ "sitename" ] = wfMsgExt( 'autocreatewiki-title-template', array( 'language' => $this->mLanguage ), $fixedTitle );

		// domain part
		$this->mDomain = preg_replace( "/(\-)+$/", "", $this->mDomain );
		$this->mDomain = preg_replace( "/^(\-)+/", "", $this->mDomain );
		$result[ "domain" ] = strtolower( trim( $this->mDomain ) );

		// hub
		$result[ "hub" ] = $this->mHub;

		switch( $this->mType ) {
			case "answers":
				$this->mWikiData[ "title"      ] = $fixedTitle . " " . $this->mDefSitename;
				break;
		}

		$result[ "language"   ] = $this->mLanguage;
		$this->mWikiData[ "subdomain"  ] = $this->mWikiData[ "name"];
		$this->mWikiData[ "redirect"   ] = $this->mWikiData[ "name"];

		$this->mWikiData[ "path"       ] = "/usr/wikia/docroot/wiki.factory";
		$this->mWikiData[ "testWiki"   ] = false;

		$this->mWikiData[ "images_url" ] = $this->prepareDirValue();
		$this->mWikiData[ "images_dir" ] = sprintf("%s/%s", strtolower( substr( $this->mWikiData[ "name"], 0, 1 ) ), $this->mWikiData[ "images_url" ]);

		if ( isset( $this->mWikiData[ "language" ] ) && $this->mWikiData[ "language" ] !== "en" ) {
			if ( $this->mLangSubdomain ) {
				$this->mWikiData[ "subdomain"  ]  = strtolower( $this->mWikiData[ "language"] ) . "." . $this->mWikiData[ "name"];
				$this->mWikiData[ "redirect"   ]  = strtolower( $this->mWikiData[ "language" ] ) . "." . ucfirst( $this->mWikiData[ "name"] );
			}
			$this->mWikiData[ "images_url" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
			$this->mWikiData[ "images_dir" ] .= "/" . strtolower( $this->mWikiData[ "language" ] );
		}

		switch( $this->mType ) {
			case "answers":
				$this->mWikiData[ "images_url" ] .= "/" . $this->mType;
				$this->mWikiData[ "images_dir" ] .= "/" . $this->mType;
				break;
		}

		$this->mWikiData[ "images_dir"    ] = self::IMGROOT  . $this->mWikiData[ "images_dir" ] . "/images";
		$this->mWikiData[ "images_url"    ] = self::IMAGEURL . $this->mWikiData[ "images_url" ] . "/images";
		$this->mWikiData[ "images_logo"   ]	= sprintf("%s/%s", $this->mWikiData[ "images_dir" ], "b/bc" );
		$this->mWikiData[ "images_icon"   ]	= sprintf("%s/%s", $this->mWikiData[ "images_dir" ], "6/64" );

		$this->mWikiData[ "domain"        ] = sprintf("%s.%s", $this->mWikiData[ "subdomain" ], $this->mDefSubdomain);
		$this->mWikiData[ "url"           ] = sprintf( "http://%s.%s/", $this->mWikiData[ "subdomain" ], $this->mDefSubdomain );
		$this->mWikiData[ "dbname"        ] = $this->prepareDBName( $this->mWikiData[ "name"], $this->awcLanguage );
		$this->mWikiData[ "founder-name"  ] = $this->mFounder->getName();
		$this->mWikiData[ "founder-email" ] = $this->mFounder->getEmail();
		$this->mWikiData[ "founder"       ] = $this->mFounder->getId();

		$this->mWikiData[ "type"          ] = $this->mType;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * set subdomain name
	 *
	 * @access private
	 * @author Piotr Molski (moli)
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @return
	 */
	private function fixSubdomains( $lang ) {

		global $wgContLang;

		wfProfileIn( __METHOD__ );
		switch( $this->mType ) {
			case "answers":
				$this->mDomains = Wikia::getAnswersDomains();
				$this->mSitenames = Wikia::getAnswersSitenames();
				if( isset($this->mDomains[ $lang ] ) && !empty( $this->mDomains[ $lang ] ) ) {
					$this->mDefSubdomain = sprintf( "%s.%s", $this->mDomains[$lang], self::DEFAULT_DOMAIN );
					$this->mLangSubdomain = false;
				}
				else {
					$this->mDefSubdomain = sprintf( "%s.%s", $this->mDomains[ "default"], self::DEFAULT_DOMAIN );
					$this->mLangSubdomain = true;
				}

				if( isset( $this->mSitenames[ $lang ] ) ) {
					$this->mDefSitename = $this->mSitenames[ $lang ];
				}
				elseif ( isset( $this->mDomains[ $lang ] ) && !empty( $this->mDomains[ $lang ] ) ) {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains[ $lang ] );
				}
				else {
					$this->mDefSitename = $wgContLang->ucfirst( $this->mDomains[ 'default' ] );
				}
				break;

			default:
				$this->mDefSubdomain = self::DEFAULT_DOMAIN;
				$this->mDefSitename = self::DEFAULT_NAME;
				$this->mDomains = array('default' => '');
				$this->mSitenames = array();
		}
		wfProfileOut( __METHOD__ );
	}

}

