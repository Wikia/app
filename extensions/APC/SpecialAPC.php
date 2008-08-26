<?php

class SpecialAPC extends SpecialPage {

	const GRAPH_SIZE = 200;

	// Stored objects

	protected $opts, $title;
	function __construct() {
		SpecialPage::SpecialPage( 'ViewAPC' );
		$this->title = $this->getTitle();
	}

	const MODE_STATS = 0;
	const MODE_SYSTEM_CACHE = 1;
	const MODE_USER_CACHE = 2;
	const MODE_SYSTEM_CACHE_DIR = 3;
	const MODE_VERSION_CHECK = 4;

	public function setup() {
		global $wgRequest;

		$opts = new FormOptions();
		// Bind to the member variable
		$this->opts = $opts;


		$opts->add( 'mode', self::MODE_STATS );
		$opts->add( 'image', APCImages::IMG_NONE );
		$opts->add( 'clearcache', false );
		$opts->add( 'limit', 20 );
		$opts->add( 'offset', 0 );
		$opts->add( 'display', '' );
		$opts->add( 'delete', '' );
		$opts->add( 'sort', 'hits' );
		$opts->add( 'sortdir', 0 );
		$opts->add( 'scope', 'active' );
		$opts->add( 'searchi', ''); // MediaWiki captures search, ARGH!

		$opts->fetchValuesFromRequest( $wgRequest );
		$opts->validateIntBounds( 'limit', 0, 5000 );
		$opts->validateIntBounds( 'sortdir', 0, 1 );
		$this->opts->consumeValues( array( 'display', 'clearcache', 'image' ) );

	}

	public function execute( $parameters ) {
		global $wgOut, $wgScriptPath, $wgStyleVersion, $wgUser;
		wfLoadExtensionMessages( 'ViewAPC' );
		$this->setHeaders();
		$this->setup();


		if( !function_exists('apc_cache_info')) {
			$wgOut->addWikiMsg( 'viewapc-apc-not-available' );
			return;
		}

		if ( $this->opts->getValue('image') ) {
			$wgOut->disable();
			header('Content-type: image/png');
			echo APCImages::generateImage( $this->opts->getValue('image') );
			return;
		}

		if ( $this->opts->getValue('mode') !== self::MODE_STATS ) {
			if ( !$wgUser->isAllowed( 'apc' ) ) {
				$wgOut->permissionRequired( 'apc' );
				return;
			}
		}



		// clear cache
		if ( $this->opts->getValue( 'clearcache' ) ) {
			$this->opts->setValue( 'clearcache', '' ); //TODO: reset
			if ( !$wgUser->isAllowed( 'apc' ) ) {
				$wgOut->permissionRequired( 'apc' );
				return;
			}
			$usermode = $this->opts->getValue( 'mode' ) === self::MODE_USER_CACHE;
			$mode = $usermode ? 'user' : 'opcode';
			apc_clear_cache( $mode );
			if ( $usermode ) {
				$wgOut->addWikiMsg( 'viewapc-filecache-cleared' );
			} else {
				$wgOut->addWikiMsg( 'viewapc-usercache-cleared' );
			}
		}

		$delete = $this->opts->getValue( 'delete' );
		if ( $delete ) {
			$this->opts->setValue( 'delete', '' ); //TODO: reset
			if ( !$wgUser->isAllowed( 'apc' ) ) {
				$wgOut->permissionRequired( 'apc' );
				return;
			}
			$result = apc_delete( $delete );
			if ( $result ) {
				$wgOut->addWikiMsg( 'viewapc-delete-ok', $delete );
			} else {
				$wgOut->addWikiMsg( 'viewapc-delete-failed', $delete );
			}
		}


		$dir = dirname( __FILE__ );
		$wgOut->addLink( array( 'rel' => 'stylesheet', 'type' => 'text/css',
			'href' => "$wgScriptPath/extensions/APC/apc.css?$wgStyleVersion", )
		);

		$this->getLogo();
		$this->mainMenu();
		$this->doPage();
	}

	protected function selfLink( $parms, $name, $attribs = array() ) {
		$title = $this->getTitle();
		$target = $title->getLocalURL( $parms );
		return Xml::element( 'a', array( 'href' => $target ) + $attribs, $name );
	}

	protected function getSelfURL( $overrides ) {
		$changed = $this->opts->getChangedValues();
		$target = $this->title->getLocalURL( wfArrayToCGI( $overrides, $changed ) );
		return $target;
	}

	protected function selfLink2( $title, $overrides ) {
		$changed = $this->opts->getChangedValues();
		$target = $this->title->getLocalURL( wfArrayToCGI( $overrides, $changed ) );
		return Xml::tags( 'a', array( 'href' => $target ), $title );
	}

	protected function menuItem( $mode, $text ) {
		$params = array( 'mode' => $mode );
		return Xml::tags( 'li', null, $this->selfLink2( $text, $params ) );
	}

	const APCURL = 'http://pecl.php.net/package/APC';
	protected function getLogo() {
		global $wgOut;

		$logo =
			Xml::wrapClass( Xml::element( 'a', array( 'href' => self::APCURL) , 'APC' ), 'mw-apc-logo' ) .
			Xml::wrapClass( 'Opcode Cache', 'mw-apc-nameinfo' );

		$wgOut->addHTML(
			Xml::openElement( 'div', array( 'class' => 'head' ) ) .
			Xml::tags( 'h1', array( 'class' => 'apc-header-1' ),
				Xml::wrapClass( $logo, 'mw-apc-logo-outer', 'span' )
			) .

			Xml::wrapClass( '', 'mw-apc-separator', 'hr' ) .
			Xml::closeElement( 'div' )
		);

	}

	protected function mainMenu() {
		global $wgUser;
		if ( !$wgUser->isAllowed( 'apc' ) ) {
			return;
		}

		$clearParams = array(
			'clearcache' => 1,
		);
		$clearText = $this->opts->getValue( 'mode' ) === self::MODE_USER_CACHE ?
			wfMsgExt( 'viewapc-clear-user-cache', 'escape' ) :
			wfMsgExt( 'viewapc-clear-code-cache', 'escape' );

		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 'ol', array( 'class' => 'mw-apc-menu' ) ) .
			$this->menuItem( self::MODE_STATS, wfMsgExt( 'viewapc-mode-stats', 'escape' ) ) .
			$this->menuItem( self::MODE_SYSTEM_CACHE, wfMsgExt( 'viewapc-mode-system-cache', 'escape' ) ) .
			//$this->menuItem( self::MODE_SYSTEM_CACHE_DIR, wfMsgExt( 'viewapc-mode-system-cache-dir', 'escape' )) .
			$this->menuItem( self::MODE_USER_CACHE, wfMsgExt( 'viewapc-mode-user-cache', 'escape' )).
			$this->menuItem( self::MODE_VERSION_CHECK, wfMsgExt( 'viewapc-mode-version-check', 'escape' )) .
			Xml::tags( 'li', null,
				$this->selfLink2( $clearText, $clearParams ) ) .
			Xml::closeElement( 'ol' )
		);
	}



	protected function doObHostStats() {
		global $wgOut, $wgLang;

		$mem = apc_sma_info();

		$clear = Xml::element( 'br', array( 'style' => 'clear: both;' ) );

		$usermode = $this->opts->getValue( 'mode' ) === self::MODE_USER_CACHE;
		$cache = apc_cache_info( $usermode ? 'user' : 'opcode' );


		$wgOut->addHTML(
			APCHostMode::doGeneralInfoTable( $cache, $mem ) .
			APCHostMode::doMemoryInfoTable( $cache, $mem, $this->title ) . $clear .
			APCHostMode::doCacheTable( $cache ) .
			APCHostMode::doCacheTable( apc_cache_info('user', 1), true ) . $clear .
			APCHostMode::doRuntimeInfoTable( $mem ) .
			APCHostMode::doFragmentationTable( $mem, $this->title ) . $clear
		);

	}


	protected function doPage() {
		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 'div', array( 'class' => 'mw-apc-content' ) )
		);

		switch ( $this->opts->getValue('mode') ) {
			case self::MODE_STATS:
				$this->doObHostStats();
				break;
			case self::MODE_SYSTEM_CACHE:
			case self::MODE_USER_CACHE:
				$mode = new APCCacheMode( $this->opts, $this->title );
				$mode->cacheView();
				break;
			case self::MODE_VERSION_CHECK:
				$this->versionCheck();
				break;
		}

		$wgOut->addHTML(
			Xml::closeElement( 'div' )
		);
	}

	protected function versionCheck() {
		global $wgOut;
		$wgOut->addHTML(
			Xml::element( 'h2', null, wfMsg( 'viewapc-version-info' ) )
		);

		$rss = @file_get_contents('http://pecl.php.net/feeds/pkg_apc.rss');
		if (!$rss) {
			$wgOut->addWikiMsg( 'viewapc-version-failed' );
		} else {
			$apcversion = phpversion('apc');

			preg_match('!<title>APC ([0-9.]+)</title>!', $rss, $match);
			if (version_compare($apcversion, $match[1], '>=')) {
				$wgOut->addWikiMsg( 'viewapc-version-ok', $apcversion );
				$i = 3;
			} else {
				$wgOut->addWikiMsg( 'viewapc-version-old', $apcversion, $match[1] );
				$i = -1;
			}

			$wgOut->addHTML(
				Xml::element( 'h3', null, wfMsg( 'viewapc-version-changelog' ) )
			);


			preg_match_all('!<(title|description)>([^<]+)</\\1>!', $rss, $match);
			next($match[2]); next($match[2]);

			while (list(,$v) = each($match[2])) {
				list(,$ver) = explode(' ', $v, 2);
				if ($i < 0 && version_compare($apcversion, $ver, '>=')) {
					break;
				} else if (!$i--) {
					break;
				}
				$data = current($match[2]);
				$wgOut->addWikiText( "''[http://pecl.php.net/package/APC/$ver $v]''<br /><pre>$data</pre>" );
				next($match[2]);
			}
		}
	}
}
