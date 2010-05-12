<?php

/**
 * MultiTaskCore
 *
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *  
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 */

define ("MULTIWIKITASK_THIS", 0) ;
define ("MULTIWIKITASK_ALL", 1) ;
define ("MULTIWIKITASK_SELECTED", 2) ;
define ("MULTIWIKITASK_CHUNK_SIZE", 250) ;

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named MultiTask.\n";
	exit(1);
}

class MultiTask extends SpecialPage {
	private $mRights;
	private $mType;
	
	public $mTaskParams;
	public $mLangOptions;
	public $mCatOptions;
	public $mFlags;
	public $mTitle;
	public $mToken;
	public $mAction;
	public $mMainForm;
	public $mFinishForm;
	public $mPreviewForm;
	public $mTaskClass;
	
	function  __construct( $type, $rights ) {
		parent::__construct( $type  /*class*/, $rights );
		wfLoadExtensionMessages( $type );
		
		$this->mType = $type;
		$this->mRights = $rights;
		
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
		
		$this->mTaskParams = array();
	}

	/**
	 * explodePages
	 *
	 * explode lines with pages
	 *
	 * @access public
	 *
	 * @return array with titles
	 */
	public function explodePages() {
		if ( !empty($this->mPage) ) {
			$lines = explode( "\n", $this->mPage );
			
			foreach ($lines as $single_line) {
				$single_page = trim($single_line);
				
				if(!empty($single_page)) {
					#-- lines with articles
					$aTitles = explode ("|", $single_page);
					
					foreach ( $aTitles as $token ) {
						$sTitle = trim($token);
						
						if(!empty($sTitle))
							$this->mTaskParams['page'][] = $sTitle;
					}
				}
			}
		}
	}

	/**
	 * fetchCountWikis
	 *
	 * generate number of wikis for selected params
	 *
	 * @access public
	 *
	 * @return number of Wikis
	 */
	public function fetchCountWikis($wikis = array(), $lang = '', $cat = 0, $city_id = 0) {
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
	 * checkRestriction
	 *
	 * check user restriction
	 *
	 * @access public
	 *
	 * @return allow (or not) to show special page
	 */
	protected function checkRestriction() {
		global $wgUser, $wgOut; 
		
		$res = true;
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			$res = false;
		}

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			$res = false;
		}

		if ( !$wgUser->isAllowed( $this->mRights ) ) {
			$this->displayRestrictionError();
			$res = false;
		}
		
		return $res;
	}

	/**
	 * parseParams
	 *
	 * parse request parameters
	 *
	 * @access protected
	 *
	 * @return none (set local variables)
	 */
	protected function parseParams() {
		global $wgRequest, $wgUser;
		$this->mAction = $wgRequest->getVal ('action');

		$this->mMode = $wgRequest->getVal( 'wpMode' );
		$this->mPage = $wgRequest->getVal( 'wpPage' );	
		$this->mWikiInbox = $wgRequest->getVal('wpWikiInbox');
		$this->mRange = $wgRequest->getVal('wpRange');
		$this->mText = $wgRequest->getVal('wpText');
		$this->mSummary = $wgRequest->getVal('wpSummary');
		$this->mMinorEdit = $wgRequest->getVal('wpMinorEdit');
		$this->mBotEdit = $wgRequest->getVal('wpBotEdit');
		$this->mAutoSummary = $wgRequest->getVal('wpAutoSummary');
		$this->mNoRecentChanges = $wgRequest->getVal('wpNoRecentChanges');
		$this->mNewOnly = $wgRequest->getVal('wpNewOnly');
		$this->mEditToken = $wgRequest->getVal('wpEditToken');
		$this->mReason = $wgRequest->getVal('wpReason');

		if ( $this->mMode == 'script' ) {
			$this->mUser = 'Maintenance script';
		} else {
			$this->mUser = $wgUser->getName();
		}

		$this->mToken = htmlspecialchars( $wgUser->editToken() );
	}
	
	/**
	 * doSubmit
	 *
	 * submit form
	 *
	 * @access private
	 *
	 * @return display form
	 */
	protected function doSubmit( $commit = 1 ) {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode;
		
		switch ( $this->mRange ) {
			case 'one' :
				if ( $commit == 1 ) {
					$this->acceptSubmit(MULTIWIKITASK_THIS);
				} else {
					$this->previewSubmit(MULTIWIKITASK_THIS);
				}
				break;
			case 'all' :
				if ( $commit == 1 ) {
					$this->acceptSubmit(MULTIWIKITASK_ALL);
				} else {
					$this->previewSubmit(MULTIWIKITASK_ALL);
				}
				break;
			case 'selected' :
				if ( empty($this->mWikiInbox) ) {
					$this->showForm( wfMsg('multiwikiedit_supply_wikis') );
					return;
				} else {
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKITASK_SELECTED);
					} else {
						$this->previewSubmit(MULTIWIKITASK_SELECTED);
					}
				}
				break;
			default :
				# language  
				if ( strpos($this->mRange, 'lang:') !== false ) {
					$lang = substr( $this->mRange, 5 ); 
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKITASK_ALL, $lang);
					} else {
						$this->previewSubmit(MULTIWIKITASK_ALL, $lang);
					}
				} 
				elseif ( strpos($this->mRange, 'cat:') !== false ) {
					$cat = substr($this->mRange, 4) ; 
					if ( $commit == 1 ) {
						$this->acceptSubmit(MULTIWIKITASK_ALL, null, $cat);
					} else {
						$this->previewSubmit(MULTIWIKITASK_ALL, null, $cat);
					}
				} 
				else {
					wfDebug("Invalid range parameter");
				}
				break;
		}
	}

	/**
	 * showForm
	 *
	 * show main form (and error message if set)
	 *
	 * @access public
	 *
	 * @return display form
	 */
	protected function showForm ($err = '') { 
		global $wgOut, $wgUser, $wgRequest ;
	
		if ( $err != "" ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
		}

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "aLangOptions"	=> $this->mLangOptions,
            "aCatOptions"	=> $this->mCatOptions,
            "obj"			=> $this,
            "err"			=> $err
        ));
        
        $wgOut->addHTML( $oTmpl->execute($this->mMainForm) );
		return true; 
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
	protected function acceptSubmit($mode = MULTIWIKITASK_THIS, $lang = '', $cat = 0) { 
		global $wgUser, $wgOut, $wgCityId ;

		$lines = explode( "\n", $this->mPage );
		$pre_wikis = array(); $wikiaId = 0;	$modeText = "";
		switch ( $mode ) {
			case MULTIWIKITASK_SELECTED : 
				$pre_wikis = explode( ",", $this->mWikiInbox );
				array_walk($pre_wikis ,create_function('&$str','$str=trim($str);'));
				$lang = $cat = "";
				$modeText = wfMsg('multiwikiedit_selected_wikis');
				break;
			case MULTIWIKITASK_ALL :
				$pre_wikis = array();
				$modeText = wfMsg('multiwikiedit_all_wikis');
				break;
			case MULTIWIKITASK_THIS : 
				$pre_wikis = array();
				$wikiaId = $wgCityId;
				$modeText = wfMsg('multiwikiedit_this_wiki');
				$lang = $cat = "";
				break;
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

					$thisTask = new $this->mTaskClass( $this->mTaskParams );
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
					) );
					$wgOut->addHTML( $oTmpl->execute($this->mFinishForm) );
				}
			}
		}
		$wgOut->addHTML( Xml::closeElement( 'ol' ) );
		$wgOut->addHtml( $this->getBackUrl() );
	}
	
	/**
	 * previewSubmit
	 *
	 * display confirmation page
	 *
	 * @access public
	 *
	 * @return display form
	 */
	protected function previewSubmit($mode = MULTIWIKITASK_THIS, $lang = '', $cat = 0) {
		global $wgUser, $wgOut, $wgCityId;

		#---
		$this->makeDefaultTaskParams($lang, $cat);

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser"		=> $wgUser,
			"mTaskParams"	=> $this->mTaskParams,
			"lang"			=> $lang,
			"cat"			=> $cat,
			"obj"			=> $this,
		) );
		$wgOut->addHTML( $oTmpl->execute( $this->mPreviewForm ) );

		$wgOut->addHtml( $this->getBackUrl() );
	}
	
	protected function makeDefaultTaskParams($lang = '', $cat = '', $city_id = 0) {
		$this->mTaskParams = array();
	}
	
	protected function getBackUrl() {
		return "";
	}
}
