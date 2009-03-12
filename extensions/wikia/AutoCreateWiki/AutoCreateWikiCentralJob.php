<?php

/**
 * AutoCreateWikiCentralJob -- Welcome user after first edit
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2009-03-12
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * register job class
 */
$wgJobClasses[ "ACWCentral" ] = "AutoCreateWikiCentralJob";

class AutoCreateWikiCentralJob extends Job {

	private
		$mStaff,
		$mFounder,
		$mWikiID,
		$mParams;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( "ACWCentral", $title, $params, $id );
		$this->mParams = $params;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
    public function run() {

		wfProfileIn( __METHOD__ );

		$this->setCentralPages();
		$this->sendWelcomeMail();

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * sendWelcomeMail
	 *
	 * sensd welcome email to founder (if founder has set email address)
	 *
	 * @author eloy@wikia-inc.com
	 * @author adi@wikia-inc.com
	 * @access private
	 *
	 * @return boolean status
	 */
	private function sendWelcomeMail() {
		global $wgDevelEnvironment, $wgUser, $wgPasswordSender;

		$oReceiver = $this->mFounder;
		if( !empty( $wgDevelEnvironment ) ) {
			$oReceiver = $wgUser;
		}

		$wikiName = WikiFactory::GetVarValueByName( "wgSitename", $this->mWikiID );
		$wikiLang = WikiFactory::GetVarValueByName( "wgLanguageCode", $this->mWikiID );

		// set apropriate staff member
		$oStaffUser = self::getStaffUserByLang( $wikiLang );
		$oStaffUser = ( $oStaffUser instanceof User ) ? $oStaffUser : $this->mStaff;

		$from = new MailAddress( $wgPasswordSender, "The Wikia Community Team" );
		$sTo = $oReceiver->getEmail();

		$aBodyParams = array(
			0 => $this->mWikiParams->city_url,
			1 => $oReceiver->getName(),
			2 => $oStaffUser->getRealName(),
			3 => htmlspecialchars( $oStaffUser->getName() ),
			4 => sprintf( "%s%s",
				rtrim($this->mWikiParams->city_url, "/"),
				$oReceiver->getTalkPage()->getLocalURL()
			),
		);

		$sBody = null;
		$sSubject = null;
		if(!empty($wikiLang)) {
			// custom lang translation
			$sBody = wfMsgExt("createwiki_welcomebody", array( 'language' => $wikiLang ), $aBodyParams);
			$sSubject = wfMsgExt("createwiki_welcomesubject", array( 'language' => $wikiLang ), array( $wikiName));
		}

		if( is_null( $sBody ) ) {
			// default lang (english)
			$sBody = wfMsg("createwiki_welcomebody", $aBodyParams);
		}
		if($sSubject == null) {
			// default lang (english)
			$sSubject = wfMsg("createwiki_welcomesubject", array($sWikiaName));
		}

		if( !empty($sTo) ) {
			$bStatus = $oReceiver->sendMail($sSubject, $sBody, $from );
			if( $bStatus === true ) {
				Wikia::log( __METHOD__, "mail", "Mail to founder {$sTo} sent.");
			}
			else {
				Wikia::log( __METHOD__, "mail", "Mail to founder {$sTo} probably not sent. sendMail returned false." );
			}
		}
		else {
			Wikia::log( __METHOD__, "mail", "Founder email is not set. Welcome email is not sent" );
		}
	}

	/**
	 * get staff member signature for given lang code
	 */
	public static function getStaffUserByLang( $langCode ) {

		wfProfileIn( __METHOD__ );

		$staffSigs = wfMsgForContent( "staffsigs" );
		$User = false;
		if( !empty( $staffSigs ) ) {
			$lines = explode("\n", $staffSigs);

			foreach( $lines as $line ) {
				if( strpos($line, '* ') === 0 ) {
					$sectLangCode = trim($line, '* ');
					continue;
				}
				if((strpos($line, '* ') == 1) && ($langCode == $sectLangCode)) {
					$sUser = trim($line, '** ');
				    $User = User::newFromName( $sUser );
					$User->load();
					return $User;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $User;
	}

	/**
	 * setCentralPage
	 *
	 * set central page with informations about created wiki
	 *
	 * @access private
	 * @author eloy@wikia
	 */
	private function setCentralPages() {
		global $wgDBname, $wgUser;

		/**
		 * do it only when run on central wikia
		*/
		if( $wgDBname != "wikicities" ) {
			Wikia::log( __METHOD__, "db", "Not run on central wikia. Cannot set wiki description page" );
			return false;
		}

		/**
		 * set user for all maintenance work on central
		 */
		$oldUser = $wgUser;
		$wgUser = User::newFromName( 'CreateWiki script' );
		Wikia::log( __METHOD__ , "user", "Creating and modifing pages on Central Wikia (as user: " . $wgUser->getName() . ")..." );

		/**
		 * title of page
		 */
		$centralTitleName = $this->mParams[ "name" ];

		#--- title for this page
		$centralTitle = Title::newFromText( $centralTitleName, NS_MAIN );

		if( $centralTitle instanceof Title ) {
			#--- and article for for this title
			Wikia::log( __METHOD__, "title", sprintf("[debug] Got title object for page: %s", $centralTitle->getFullUrl( ) ) );
		    $oCentralArticle = new Article( $centralTitle, 0);
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/CreateWikiTask/" );
			$oTmpl->set_vars( array(
				"data"          => $this->mTaskData,
				"wikid"         => $this->mWikiID,
				"param"         => $this->mTaskParams,
				"founder"       => $this->mFounder,
				"timestamp"     => $sTimeStamp = gmdate("j F, Y"),
				"categories"    => wfStringToArray( $this->mTaskParams["wpCreateWikiCategory"], ",", 5 )
			));

			if(!$oCentralArticle->exists()) {
				#--- create article
				Wikia::log( __METHOD__, "article", sprintf("[debug] Creating new article: %s", $centralTitle->getFullUrl( ) ) );

				$sPage = $oTmpl->execute("central-maindescription");
				$sPage.= $oTmpl->execute("central");

				Wikia::log( __METHOD__, "article", "[debug] Page body formatted, launching doEdit() ..." );
				$oCentralArticle->doEdit( $sPage, "created by task manager", EDIT_FORCE_BOT );
				Wikia::log( __METHOD__, "article", sprintf("Article %s added.", $centralTitle->getFullUrl()) );
			}
			else {
				#--- update article
				Wikia::log( __METHOD__, "article", sprintf("[debug] Updating existing article: %s", $centralTitle->getFullUrl()) );

				$sContent = $oCentralArticle->getContent();
				$sContent.= $oTmpl->execute("central");

				$oCentralArticle->doEdit( $sContent, "modified by task manager", EDIT_FORCE_BOT );
				Wikia::log( __METHOD__, "article", sprintf("Article %s already exists... content added", $centralTitle->getFullUrl()) );
			}
		}
		else {
			Wikia::log( __METHOD__, "article", "ERROR: Unable to create title object for page on Central Wikia: " . $sCentralTitle );
			return false;
		}

		/**
		 * add to Template:List_of_Wikia_New
		 */
		$sCentralListTitle = 'Template:List_of_Wikia_New';
		$oCentralListTitle = Title::newFromText( $sCentralListTitle, NS_MAIN );
		if($oCentralListTitle instanceof Title) {
			$oCentralListArticle = new Article( $oCentralListTitle, 0);
			if( $oCentralListArticle->exists() ) {
				$sContent = $oCentralListArticle->getContent();
				$sContent.= "{{subst:nw|" . $this->mTaskData['subdomain'] . "|" . $sCentralTitle . "|" . $this->mTaskData['language'] . "}}";

				$oCentralListArticle->doEdit( $sContent, "modified by task manager", EDIT_FORCE_BOT);
				$this->addLog( sprintf("Article %s modified.", $oCentralListTitle->getFullUrl()) );
			}
			else {
				$this->addLog( sprintf("Article %s not exists.", $oCentralListTitle->getFullUrl()) );
			}

			#--- add to New_wikis_this_week/Draft
			$sCentralListTitle = 'New_wikis_this_week/Draft';
			$oCentralListTitle = Title::newFromText( $sCentralListTitle, NS_MAIN );
			$oCentralListArticle = new Article( $oCentralListTitle, 0);

			if($oCentralListArticle->exists()) {
				$oHub = WikiFactoryHub::getInstance();
				$aHubs = $oHub->getCategories();
				$sReplace = "{{nwtw|" . $this->mTaskData['language'] . "|" . $aHubs[$this->mTaskParams['wpWikiCategory']] . "|" . $sCentralTitle . "|http://" . $this->mTaskData['subdomain'] . ".wikia.com}}\n|}";
				$sContent = str_replace("|}", $sReplace, $oCentralListArticle->getContent());

				$oCentralListArticle->doEdit( $sContent, "modified by task manager", EDIT_FORCE_BOT);
				$this->addLog( sprintf("Article %s modified.", $oCentralListTitle->getFullUrl()) );
			}
			else {
				$this->addLog( sprintf("Article %s not exists.", $oCentralListTitle->getFullUrl()) );
			}
		}
		else {
			$this->addLog( "ERROR: Unable to create title object for page: " . $sCentralListTitle);
			return false;
		}

		if(strcmp(strtolower($this->mTaskData['redirect']), strtolower($sCentralTitle)) != 0) {
			#--- add redirect(s) on central
			$oCentralRedirectTitle = Title::newFromText( $this->mTaskData['redirect'], NS_MAIN );
			if( $oCentralRedirectTitle instanceof Title ) {
				$oCentralRedirectArticle = new Article( $oCentralRedirectTitle, 0);
				if( !$oCentralRedirectArticle->exists() ) {
					$sContent = "#Redirect [[" . $sCentralTitle . "]]";
					$oCentralRedirectArticle->doEdit( $sContent, "modified by task manager", EDIT_FORCE_BOT);
					$this->addLog( sprintf("Article %s added (redirect to: " . $sCentralTitle . ").", $oCentralRedirectTitle->getFullUrl()) );
				}
				else {
					$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
				}

				if( ($this->mTaskData['language'] == 'en') && (!eregi("^en.", $this->mTaskData['subdomain'])) ) {
					// extra redirect page: en.<subdomain>
					$sCentralRedirectTitle = 'en.' . $this->mTaskData['subdomain'];
					$oCentralRedirectTitle = Title::newFromText( $sCentralRedirectTitle, NS_MAIN );
					if( !$oCentralRedirectArticle->exists() ) {
						$sContent = "#Redirect [[" . $sCentralTitle . "]]";
						$oCentralRedirectArticle->doEdit( $sContent, "modified by task manager", EDIT_FORCE_BOT);
						$this->addLog( sprintf("Article %s added (extra redirect to: " . $sCentralTitle . ").", $oCentralRedirectTitle->getFullUrl()) );
					}
					else {
						$this->addLog( sprintf("Article %s already exists.", $oCentralRedirectTitle->getFullUrl()) );
					}
				}
			}
			else {
				$this->addLog( "ERROR: Unable to create title object for redirect page: " . $this->mTaskData['redirect']);
				return false;
			}
		}

		/**
		 * revert back to original User object, just in case
		 */
		$wgUser = $oldUser;

		$this->addLog( "Creating and modifing pages on Central Wikia finished." );
		return true;
	}

}
