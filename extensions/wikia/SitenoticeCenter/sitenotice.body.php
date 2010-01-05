<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Chris Stafford <uberfuzzy@wikia.com> for Wikia.com/MediaWiki
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class SitenoticeCenter extends SpecialPage {
	private $my_ro = false;
	private $my_ib = false;
	private $mCookieName;
	private $mCookie;


	function  __construct() {
		parent::__construct( "SitenoticeCenter" , '' /*restriction*/);
		wfLoadExtensionMessages("SitenoticeCenter");
		$this->mCookieName = 'dismissSiteNotice';
		$this->mCookie = false;
	}

	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if( wfReadOnly() ) {
			//ext can be used in view mode during RO, just not the 'do' parts
			$this->my_ro = true;
		}
		if( $wgUser->isBlocked() ) {
			//dont stop them, just mark that they are, for later use
			$this->my_ib = true;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Sitenotice' );
		$wgOut->setPageTitle( wfMsg('sitenoticecenter-title') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * grab cookie value now
		 */
		if( array_key_exists($this->mCookieName, $_COOKIE) )
		{
			$this->mCookie =  $_COOKIE[ $this->mCookieName ];
		}

		/**
		 * if asked, do
		 */
		if( $wgRequest->wasPosted() )
		{
			switch($wgRequest->getVal( 'do', null ) )
			{
				case 'auto':
					$this->doAuto();
					break;
				case 'cookie':
					$this->clear_cookie();
					break;
				default:
					//uh...
					break;
			}
		}

		/**
		 * show form
		 */
		$this->makePage();
	}

	function makePage()
	{
		global $wgOut, $wgUser, $wgTitle;

		$wgOut->addWikiMsg( 'sitenoticecenter-desc' );

		/*********************************************************************************/
		$wgOut->addHTML( Xml::element( 'h2', null, wfMsg( 'sitenoticecenter-messages' ) ) );

		$canEdit = $wgUser->isAllowed('editinterface');

		if($canEdit)
		{
			$linktext = wfMsg('sitenoticecenter-edit');
		}
		else
		{
			$linktext = wfMsg('sitenoticecenter-view');
		}

		$things = array('Sitenotice', 'Anonnotice', 'Sitenotice_id');

		foreach($things as $pn)
		{
			$title = Title::newFromText($pn, NS_MEDIAWIKI);

			$link = Xml::element('a', array('href'=>$title->getLocalURL()), $linktext);
			$fs_title = "<b>{$pn}</b> [ {$link} ]";

			$wgOut->addHTML( Xml::openElement('fieldset') . "\n" );
			$wgOut->addHTML( Xml::tags('legend', null, $fs_title) . "\n" );

			$fs_content = wfMsg($pn);
			if (wfEmptyMsg($pn, $fs_content) || trim($fs_content) == '-') {
				//empty
				$fs_content = Xml::element('i', null, wfMsg('sitenoticecenter-nomessage')) . "\n";
			}else{
				//not empty

				if($pn != 'Sitenotice_id')
				{
					//if not the id, wrap in div to fake the formatting that is used on top of page
					//YES, i know this duplicates ID's on a page, but no other way around it.
					$fs_content = Xml::tags('div', array('id'=>'siteNotice'), $fs_content) . "\n";
				}
			}

			$wgOut->addHTML( $fs_content );

			if( $pn == 'Sitenotice_id' && $canEdit && !$this->my_ro && !$this->my_ib )
			{
				$wgOut->addHTML( Xml::element('hr', null, '') );
				$wgOut->addHTML( Xml::openElement( "form", array( "action" => $wgTitle->getFullURL(), "method" => "post" ) ) );
				$wgOut->addHTML( Xml::hidden( 'do', 'auto' ) );
				$wgOut->addHTML( Xml::submitButton( wfMsg('sitenoticecenter-button-auto') ) );
				$wgOut->addHTML( Xml::closeElement( "form" ) );
			}

			$wgOut->addHTML( Xml::closeElement('fieldset') . "\n" );
		}

		/*********************************************************************************/
		$wgOut->addHTML( Xml::element('h2', null, wfMsg( 'sitenoticecenter-cookie' ) ) );

		if( !empty($this->mCookie) )
		{
			$wgOut->addHTML( Xml::openElement( "form", array( "action" => $wgTitle->getFullURL(), "method" => "post" ) ) );
			$wgOut->addHTML( Xml::hidden( 'do', 'cookie' ) );
			$wgOut->addHTML( Xml::submitButton( wfMsg('sitenoticecenter-button-cookie') ) );
			$wgOut->addHTML( Xml::closeElement( "form" ) );
		}
		else
		{
			$wgOut->addHTML( Xml::element('i', null, wfMsg('sitenoticecenter-nocookie') ) );
		}

	}

	private function doAuto()
	{
		if( $this->my_ro || $this->my_ib ) return;

		global $wgUser;

		$title = Title::newFromText('Sitenotice_id', NS_MEDIAWIKI);

		if($title->userCan('edit') && !$this->my_ib) {
			$article = new Article($title);
			$article_text = time(); //always higher then the last :)
			$edit_summary = wfMsgForContent('sitenoticecenter-summary');
			$flags = EDIT_UPDATE & EDIT_NEW;
			if ($wgUser->isAllowed('bot')) {
				$flags |= EDIT_FORCE_BOT;
			}

			$article->doEdit($article_text, $edit_summary, $flags);
		}

	}

	private function clear_cookie()
	{
		global $wgRequest, $wgCookiePrefix;

		$wCP = $wgCookiePrefix; //backup
		$wgCookiePrefix = ''; //clear
		//we do this so we can set the cookie name, without the MW prefix in the way

		$wgRequest->response()->setcookie( $this->mCookieName, "", -1 );

		//restore
		$wgCookiePrefix = $wCP;

		//and 'forget' this page had a cookie
		$this->mCookie = false;
	}
}
