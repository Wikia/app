<?php

/**
 * The page that's initially called by MediaWiki when navigating to 
 * Special:SecurePoll.  The actual pages are not actually subclasses of
 * this or of SpecialPage, they're subclassed from SecurePoll_Page.
 */
class SecurePoll_BasePage extends UnlistedSpecialPage {
	static $pages = array(
		'details' => 'SecurePoll_DetailsPage',
		'dump' => 'SecurePoll_DumpPage',
		'entry' => 'SecurePoll_EntryPage',
		'list' => 'SecurePoll_ListPage',
		'login' => 'SecurePoll_LoginPage',
		'msgdump' => 'SecurePoll_MessageDumpPage',
		'tally' => 'SecurePoll_TallyPage',
		'translate' => 'SecurePoll_TranslatePage',
		'vote' => 'SecurePoll_VotePage',
	);

	var $sp_context;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'SecurePoll' );
		$this->sp_context = new SecurePoll_Context;
	}

	/**
	 * Show the special page
	 *
	 * @param $paramString Mixed: parameter passed to the page or null
	 */
	public function execute( $paramString ) {
		global $wgOut, $wgRequest, $wgScriptPath;

		$this->setHeaders();
		$wgOut->addLink( array(
			'rel' => 'stylesheet',
			'href' => "$wgScriptPath/extensions/SecurePoll/resources/SecurePoll.css",
			'type' => 'text/css'
		) );
		$wgOut->addScriptFile( "$wgScriptPath/extensions/SecurePoll/resources/SecurePoll.js" );

		$this->request = $wgRequest;

		$paramString = strval( $paramString );
		if ( $paramString === '' ) {
			$paramString = 'entry';
		}
		$params = explode( '/', $paramString );
		$pageName = array_shift( $params );
		$page = $this->getSubpage( $pageName );
		if ( !$page ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-page', $pageName );
			return;
		}

		if ( !($page instanceof SecurePoll_EntryPage ) ) {
			$this->setSubtitle();
		}

		$page->execute( $params );
	}

	/**
	 * Get a SecurePoll_Page subclass object for the given subpage name
	 */
	function getSubpage( $name ) {
		if ( !isset( self::$pages[$name] ) ) {
			return false;
		}
		$className = self::$pages[$name];
		$page = new $className( $this );
		return $page;
	}

	/**
	 * Get a random token for CSRF protection
	 */
	function getEditToken() {
		if ( !isset( $_SESSION['spToken'] ) ) {
			$_SESSION['spToken'] = sha1( mt_rand() . mt_rand() . mt_rand() );
		}
		return $_SESSION['spToken'];
	}

	/**
	 * Set a navigation subtitle.
	 * Each argument is a two-element array giving a Title object to be used as 
	 * a link target, and the link text.
	 */
	function setSubtitle( /*...*/ ) {
		global $wgUser, $wgOut;
		$skin = $wgUser->getSkin();
		$title = $this->getTitle();
		$subtitle = '&lt; ' . $skin->linkKnown( $title, htmlspecialchars( $title->getText() ) );
		$pipe = wfMsg( 'pipe-separator' );
		$links = func_get_args();
		foreach ( $links as $link ) {
			list( $title, $text ) = $link;
			$subtitle .= $pipe . $skin->linkKnown( $title, htmlspecialchars( $text ) );
		}
		$wgOut->setSubtitle( $subtitle );
	}
}
