<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class Multiwikiedit extends SpecialPage {
	public $mTitle;
	public $mToken;
	public $mAction;
	public $mTaskParams;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "Multiwikiedit"  /*class*/, "multiwikiedit");
		wfLoadExtensionMessages("Multiwikiedit");
	}
	
	/**
	 * execute
	 *
	 * execute special page
	 *
	 * @access public
	 *
	 * @return none
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if ( !$wgUser->isAllowed( 'multiwikiedit' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/* */		
		$this->mTaskParams = array();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Multiwikiedit' );
		$this->mToken = htmlspecialchars( $wgUser->editToken() );
		$this->parseParams();

		$wgOut->setPageTitle( wfMsg('multiwikiedit_title') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$this->mLangOptions = array(
			'one' 			=> wfMsg('multiwikiedit_this_wiki'),
			'all' 			=> wfMsg('multiwikiedit_all_wikis'),
			'selected'		=> wfMsg ('multiwikiedit_selected_wikis'),
			'lang:pt-br' 	=> wfMsg ('multidelete_brazilian_portuguese_wikis'),
			'lang:he' 		=> wfMsg ('multidelete_hebrew_wikis'),
			'lang:zh'		=> wfMsg ('multidelete_chinese_wikis'),
			'lang:pl'		=> wfMsg ('multidelete_polish_wikis'),
			'lang:cs'		=> wfMsg ('multidelete_czech_wikis'),
			'lang:pt'		=> wfMsg ('multidelete_portuguese_wikis'),
			'lang:nl'		=> wfMsg ('multidelete_dutch_wikis'),
			'lang:it'		=> wfMsg ('multidelete_italian_wikis'),
			'lang:ru'		=> wfMsg ('multidelete_russian_wikis'),
			'lang:en'		=> wfMsg ('multidelete_english_wikis'),
			'lang:ja'		=> wfMsg ('multidelete_japanese_wikis'),
			'lang:fi'		=> wfMsg ('multidelete_finnish_wikis'),
			'lang:es'		=> wfMsg ('multidelete_spanish_wikis'),
			'lang:fr'		=> wfMsg ('multidelete_french_wikis'),
			'lang:sv'		=> wfMsg ('multidelete_swedish_wikis'),
			'lang:de'		=> wfMsg ('multidelete_german_wikis'),
		);
		
		$this->mCatOptions = array(
			'cat:18' 		=> 'all auto hub wiki',
			'cat:17' 		=> 'all creative hub wiki',
			'cat:8'			=> 'all education hub wiki',
			'cat:3'			=> 'all entertainment hub wiki',
			'cat:10'		=> 'all finance hub wiki',
			'cat:2' 		=> 'all gaming hub wiki',
			'cat:19'		=> 'all green hub wiki',
			'cat:1' 		=> 'all humor hub wiki',
			'cat:9' 		=> 'all lifestyle hub wiki',
			'cat:16'		=> 'all music hub wiki',
			'cat:14'		=> 'all philosophy hub wiki',
			'cat:11'		=> 'all politics hub wiki',
			'cat:13'		=> 'all science hub wiki',
			'cat:15'		=> 'all sports hub wiki',
			'cat:12'		=> 'all technology hub wiki',
			'cat:5'			=> 'all toys hub wiki',
			'cat:7'			=> 'all travel hub wiki',
			'cat:4'			=> 'all wikia hub wiki'
		);
		
		$this->mFlags = array(
			wfMsg('multiwikiedit_minoredit_caption'),
			wfMsg('multiwikiedit_botedit_caption'),
			wfMsg('multiwikiedit_autosummary_caption'),
			wfMsg('multiwikiedit_norecentchanges_caption'),
			wfMsg('multiwikiedit_newonly_caption')
		);
		
		if ( $this->mAction == 'success' ) {
			// do something?
		} 
		else if ( ( $wgRequest->wasPosted() ) && ( $this->mAction == 'submit' ) && ( $wgUser->matchEditToken( $this->mEditToken ) ) ) {
			if ( !$this->mPage ) {
				$this->showForm( wfMsg('multiwikiedit_no_page') );
			} 
			elseif ( $this->mText == '' ) {
				$this->showForm( wfMsg('multiwikiedit_add_text') ) ;
			}
			else {
				$this->doSubmit(0);
			}
		} 
		else if ( ( $wgRequest->wasPosted() ) && ( $this->mAction == 'addTask' ) && ( $wgUser->matchEditToken( $this->mEditToken ) ) ) {
			if ( !$this->mPage ) {
				$this->showForm( wfMsg('multiwikiedit_no_page') );
			} 
			elseif ( $this->mText == '' ) {
				$this->showForm( wfMsg('multiwikiedit_add_text') ) ;
			}
			else {
				$this->doSubmit(1);
			}
		}
		else {
			$this->showForm() ;
		}
	}
	
	/**
	 * parseParams
	 *
	 * parse request parameters
	 *
	 * @access private
	 *
	 * @return none (set local variables)
	 */
	private function parseParams() {
		global $wgRequest, $wgUser;
		$this->mAction = $wgRequest->getVal ('action');

		$this->mMode = $wgRequest->getVal( 'wpMode' );
		$this->mPage = $wgRequest->getVal( 'wpPage' );	
		$this->mWikiInbox = $wgRequest->getVal ('wpWikiInbox');
		$this->mRange = $wgRequest->getVal ('wpRange');
		$this->mText = $wgRequest->getVal ('wpText');
		$this->mSummary = $wgRequest->getVal ('wpSummary');
		$this->mMinorEdit = $wgRequest->getVal ('wpMinorEdit');
		$this->mBotEdit = $wgRequest->getVal ('wpBotEdit');
		$this->mAutoSummary = $wgRequest->getVal ('wpAutoSummary');
		$this->mNoRecentChanges = $wgRequest->getVal ('wpNoRecentChanges');
		$this->mNewOnly = $wgRequest->getVal ('wpNewOnly');
		$this->mEditToken = $wgRequest->getVal ('wpEditToken');

		if ( $this->mMode == 'script' ) {
			$this->mUser = 'Maintenance script';
		} else {
			$this->mUser = $wgUser->getName();
		}
	}

	/**
	 * showForm
	 *
	 * show main form (and error message if set)
	 *
	 * @access private
	 *
	 * @return display form
	 */
	private function showForm ($err = '') {
		global $wgOut, $wgUser, $wgRequest ;
	
		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "mTitle" 		=> $this->mTitle,
            "mAction"		=> $this->mAction,
            "aLangOptions"	=> $this->mLangOptions,
            "aCatOptions"	=> $this->mCatOptions,
            "obj"			=> $this,
        ));
        
        $wgOut->addHTML( $oTmpl->execute("main-form") );
	}
	
	/**
	 * doConfirmSubmit
	 *
Notice: Undefined variable: countWikis in /home/moli/wikia/trunk/extensions/wikia/MultiWikiEdit/SpecialMultiWikiEdit_body.php on line 311
	 * submit form
	 *
	 * @access private
	 *
	 * @return display form
	 */
	private function doSubmit( $commit = 1 ) {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode;
		
		$wgOut->setSubTitle ( wfMsg('multiwikiedit_processing') . wfMsg ('multiwikiedit_from_form') );
		
		switch ( $this->mRange ) {
			case 'one' :
				if ( $commit == 1 ) {
					$this->acceptSubmit(MULTIWIKIEDIT_THIS);
				} else {
					$this->previewSubmit(MULTIWIKIEDIT_THIS);
				}
				break;
			case 'all' :
				if ( $commit == 1 ) {
					$this->acceptSubmit(MULTIWIKIEDIT_ALL);
				} else {
					$this->previewSubmit(MULTIWIKIEDIT_ALL);
				}
				break;
			case 'selected' :
				if ( empty($this->mWikiInbox) ) {
					$this->showForm( wfMsg('multiwikiedit_supply_wikis') );
					return;
				} else {
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKIEDIT_SELECTED);
					} else {
						$this->previewSubmit(MULTIWIKIEDIT_SELECTED);
					}
				}
				break;
			default :
				# language  
				if ( strpos($this->mRange, 'lang:') !== false ) {
					$lang = substr( $this->mRange, 5 ); 
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKIEDIT_ALL, $lang);
					} else {
						$this->previewSubmit(MULTIWIKIEDIT_ALL, $lang);
					}
				} 
				elseif ( strpos($this->mRange, 'cat:') !== false ) {
					$cat = substr($this->mRange, 4) ; 
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKIEDIT_ALL, null, $cat);
					} else {
						$this->previewSubmit(MULTIWIKIEDIT_ALL, null, $cat);
					}
				} 
				else {
					wfDebug("Invalid range parameter");
				}
				break;
		}
	}
	
	/**
	 * previewSubmit
	 *
	 * display message after submit action
	 *
	 * @access private
	 *
	 * @return display form
	 */
	function previewSubmit($mode = MULTIWIKIEDIT_THIS, $lang = '', $cat = 0) {
		global $wgUser, $wgOut, $wgCityId;

		$lines = explode( "\n", $this->mPage );
		#---
		$this->makeDefaultTaskParams($lang, $cat);
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		foreach ($lines as $single_page) {
			#-- lines with articles
			$aTitles = explode ("|", trim ($single_page) ) ;
			
			if ( !empty($aTitles) ) {
				foreach ( $aTitles as $sTitle ) {
					$this->mTaskParams['page'][] = $sTitle;
				}
			}
		}

		$oTmpl->set_vars( array(
			"wgUser"		=> $wgUser,
			"mTaskParams"	=> $this->mTaskParams,
			"lang"			=> $lang,
			"cat"			=> $cat,
			"obj"			=> $this,
		) );
		$wgOut->addHTML( $oTmpl->execute("confirm-form") );

		$sk = $wgUser->getSkin () ;	
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Multiwikiedit' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/><br/>".wfMsg('multiwikiedit_link_back')." ".$link_back.".") ;
	}

	/**
	 * acceptSubmit
	 *
	 * display message after submit action
	 *
	 * @access private
	 *
	 * @return display form
	 */
	function acceptSubmit($mode = MULTIWIKIEDIT_THIS, $lang = '', $cat = 0) {
		global $wgUser, $wgOut, $wgCityId ;

		$lines = explode( "\n", $this->mPage );
		$pre_wikis = array(); 
		$wikiaId = 0;
		$modeText = "";
		switch ( $mode ) {
			case MULTIWIKIEDIT_SELECTED : 
				$pre_wikis = explode( ",", $this->mWikiInbox );
				array_walk($pre_wikis ,create_function('&$str','$str=trim($str);'));
				$lang = $cat = "";
				$modeText = wfMsg('multiwikiedit_selected_wikis');
				break;
			case MULTIWIKIEDIT_ALL :
				$pre_wikis = array();
				$modeText = wfMsg('multiwikiedit_all_wikis');
				break;
			case MULTIWIKIEDIT_THIS : 
				$pre_wikis = array();
				$wikiaId = $wgCityId;
				$modeText = wfMsg('multiwikiedit_this_wiki');
				$lang = $cat = "";
		}
		#---
		$countWikis = $this->fetchCountWikis($pre_wikis, $lang, $cat, $wikiaId);
		
		#---
		$this->makeDefaultTaskParams($lang, $cat, $wikiaId);

		$wgOut->addHTML("<p><strong>". wfMsg('multiwikiedit_tasks_list') . ": </strong></p>");
		$wgOut->addHTML( Xml::openElement( 'ol', null ) );
		foreach ($lines as $single_page) {
			#-- lines with articles
			$aTitles = explode ("|", trim ($single_page) ) ;
			
			if ( !empty($aTitles) ) {
				$loop = 0;
				foreach ( $aTitles as $sTitle ) {
					$loop++;
					$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
					$this->mTaskParams['page'] = $sTitle;

					$thisTask = new MultiWikiEditTask( $this->mTaskParams );
					$submit_id = $thisTask->submitForm();
					
					$oTmpl->set_vars( array(
						"modeText" 		=> $modeText,
						"wgUser"		=> $wgUser,
						"sTitle"		=> $sTitle,
						"mTaskParams"	=> $this->mTaskParams,
						"countWikis"	=> $countWikis,
						"lang"			=> $lang,
						"cat"			=> $cat,
						"obj"			=> $this,
						"submit_id"		=> $submit_id,
						"error"			=> ($submit_id === false),
						"mFlags"		=> $this->mFlags
					) );
					$wgOut->addHTML( $oTmpl->execute("row-list") );
				}
			}
		}
		$wgOut->addHTML( Xml::closeElement( 'ol' ) );

		$sk = $wgUser->getSkin () ;	
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Multiwikiedit' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/><br/>".wfMsg('multiwikiedit_link_back')." ".$link_back.".") ;
	}
	
	/**
	 * fetchCountWikis
	 *
	 * return number of wikis for params
	 *
	 * @access private
	 *
	 * @return integer (count of wikis)
	 */
	private function fetchCountWikis($wikis = array(), $lang = '', $cat = 0, $city_id = 0) {
		global $wgExternalSharedDB ;
		$dbr = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

		$where = array();	
		$count = 0;	
		if (!empty($lang)) {
			$where['city_lang'] = $lang;
		} 
		else if (!empty($cat)) {
			$where['cat_id'] = $cat;
		}
		
		if ( !empty($city_id) ) {
			$where['city_list.city_id'] = $city_id;
		}
		
		if ( empty($wikis) ) {
			$oRow = $dbr->selectRow(
				array( "city_list join city_cat_mapping on city_cat_mapping.city_id = city_list.city_id" ),
				array( "count(*) as cnt" ),
				$where,
				__METHOD__
			);
			$count = intval($oRow->cnt);
		} else {
			$where[] = "city_list.city_id = city_domains.city_id";
			$where[] = " city_domain in ('" . implode("','", $wikis) . "') ";

			$oRow = $dbr->selectRow(
				array( "city_list", "city_domains" ),
				array( "count(*) as cnt" ),
				$where,
				__METHOD__
			);
			
			$count = intval($oRow->cnt);
		}
		return $count;
	}

	/**
	 * makeDefaultTaskParams
	 *
	 * make params of tasks
	 *
	 * @access private
	 *
	 * @return none (set local variables)
	 */
	private function makeDefaultTaskParams($lang = '', $cat = '', $city_id = 0) {
		global $wgUser;
		
		$this->mTaskParams['mode'] = $this->mMode;
		$this->mTaskParams['page'] = $this->mPage;
		$this->mTaskParams['wikis'] = $this->mWikiInbox;
		$this->mTaskParams['range'] = $this->mRange;
		$this->mTaskParams['text'] = $this->mText;
		$this->mTaskParams['summary'] = $this->mSummary;
		$this->mTaskParams['lang'] = $lang;
		$this->mTaskParams['cat'] = $cat;		
		$this->mTaskParams['selwikia'] = $city_id;

		$this->mTaskParams['flags'] = array(
			$this->mMinorEdit, 
			$this->mBotEdit,
			$this->mAutoSummary,
			$this->mNoRecentChanges,
			$this->mNewOnly
		);
		$this->mTaskParams['edittoken'] = $this->mEditToken;
		$this->mTaskParams['user'] = $this->mUser;
		
		$this->mTaskParams['admin'] = $wgUser->getName();
		
		$this->mTaskParams['page'] = array();
	}
}
