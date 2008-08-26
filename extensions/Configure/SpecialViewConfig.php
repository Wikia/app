<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page allows authorised users to see wiki's configuration
 * This should also be available if efConfigureSetup() hasn't been called
 *
 * @ingroup Extensions
 */
class SpecialViewConfig extends ConfigurationPage {
	protected $isWebConfig;
	protected $mRequireWebConf = false;
	protected $mCanEdit = false;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ViewConfig', 'viewconfig' );
	}

	protected function getSettingMask(){
		return CONF_SETTINGS_BOTH;	
	}

	protected function getVersion(){
		global $wgOut, $wgRequest, $wgConf;

		$this->isWebConfig = $wgConf instanceof WebConfiguration;

		if( $this->isWebConfig && $version = $wgRequest->getVal( 'version' ) ){
			$versions = $wgConf->listArchiveFiles();
			if( in_array( $version, $versions ) ){
				$conf = $wgConf->getOldSettings( $version );
				if( $this->isUserAllowedAll() ){
					$wiki = $wgRequest->getVal( 'wiki', $wgConf->getWiki() );
				} else {
					$wiki = $wgConf->getWiki();
				}

				$this->version = $version;
				$this->wiki = $wiki;

				if( $diff = $wgRequest->getVal( 'diff' ) ){
					if( !in_array( $diff, $versions ) ){
						$msg = wfMsgNoTrans( 'configure-old-not-available', $diff );
						$wgOut->addWikiText( "<div class='errorbox'>$msg</div>" );
						return;
					}
					$this->diff = $diff;
				}

				if( isset( $conf[$wiki] ) ){
					$this->conf = $conf[$wiki];
				} else if( !isset( $this->diff ) ){
					$msg = wfMsgNoTrans( 'configure-old-not-available', $version );
					$wgOut->addWikiText( "<div class='errorbox'>$msg</div>" );
					return false;
				}
			} else {
				$msg = wfMsgNoTrans( 'configure-old-not-available', $version );
				$wgOut->addWikiText( "<div class='errorbox'>$msg</div>" );
				return false;
			}
		}

		return true;
	}

	/**
	 * Just in case, security
	 */
	protected function doSubmit(){}

	/**
	 * Show diff
	 */
	protected function showDiff(){
		global $wgOut;
		$wikis = $this->isUserAllowedAll() ? true : array( $this->wiki );
		$diffEngine = new HistoryConfigurationDiff( $this->diff, $this->version, $wikis );
		$diffEngine->setViewCallback( array( $this, 'userCanRead' ) );
		$wgOut->addHtml( $diffEngine->getHTML() );
	}

	/**
	 * Show the main form
	 */
	protected function showForm(){
		global $wgOut, $wgRequest;

		if( !$this->isWebConfig || !empty( $this->conf ) || isset( $this->diff ) ){
			if( isset( $this->diff ) ){
				$this->showDiff();
			} else {
				$wgOut->addHtml(
					Xml::openElement( 'div', array( 'id' => 'configure-form' ) ) . "\n" .
					Xml::openElement( 'div', array( 'id' => 'configure' ) ) . "\n" .
	
					$this->buildAllSettings() . "\n" .
	
					Xml::closeElement( 'div' ) . "\n" .
					Xml::closeElement( 'div' ) . "\n"
				);
			}
		} else {
			$wgOut->addHtml( $this->buildOldVersionSelect() );
		}
		$this->injectScriptsAndStyles();
	}

	/**
	 * Build links to old version of the configuration
	 * 
	 */
	protected function buildOldVersionSelect(){
		global $wgConf, $wgLang, $wgUser, $wgScript;
		if( !$this->isWebConfig )
			return '';

		$versions = $wgConf->listArchiveFiles();
		if( empty( $versions ) ){
			return wfMsgExt( 'configure-no-old', array( 'parse' ) );
		}

		$title = $this->getTitle();
		$skin = $wgUser->getSkin();
		$showDiff = count( $versions ) > 1;

		$allowedConfig = $wgUser->isAllowed( 'configure' );
		$allowedExtensions = $wgUser->isAllowed( 'extensions' );

		$allowedAll = $this->isUserAllowedInterwiki();
		$allowedConfigAll = $wgUser->isAllowed( 'configure-interwiki' );
		$allowedExtensionsAll = $wgUser->isAllowed( 'extensions-interwiki' );

		if( $allowedConfig )
			$configTitle = is_callable( array( 'SpecialPage', 'getTitleFor' ) ) ? # 1.9 +
				SpecialPage::getTitleFor( 'Configure' ) :
				Title::makeTitle( NS_SPECIAL, 'Configure' );

		if( $allowedExtensions )
			$extTitle = is_callable( array( 'SpecialPage', 'getTitleFor' ) ) ? # 1.9 +
				SpecialPage::getTitleFor( 'Extensions' ) :
				Title::makeTitle( NS_SPECIAL, 'Extensions' );

		$text = wfMsgExt( 'configure-old-versions', array( 'parse' ) );
		if( $showDiff )
			$text .= Xml::openElement( 'form', array( 'action' => $wgScript ) ) . "\n" .
			Xml::hidden( 'title', $title->getPrefixedDBKey() ) . "\n" .
			$this->getButton() . "\n";
		$text .= "<ul>\n";
		
		$editMsg = wfMsg( 'edit' ) . ': ';
		$c = 0;
		foreach( array_reverse( $versions ) as $ts ){
			$c++;
			$time = $wgLang->timeAndDate( $ts );
			if( $allowedAll || $allowedConfigAll ){
				$settings = $wgConf->getOldSettings( $ts );
				$wikis = array_keys( $settings );
			}
			$actions = array();
			$view = $skin->makeKnownLinkObj( $title, wfMsg( 'configure-view' ), "version=$ts" );
			if( $allowedAll ){
				$viewWikis = array();
				foreach( $wikis as $wiki ){
					$viewWikis[] = $skin->makeKnownLinkObj( $title, $wiki, "version={$ts}&wiki={$wiki}" );
				}
				$view .= ' (' . implode( ', ', $viewWikis ) . ')';
			}
			$actions[] = $view;
			$editDone = false;
			if( $allowedConfig ){
				$editCore = $editMsg . $skin->makeKnownLinkObj( $configTitle, wfMsg( 'configure-edit-core' ), "version=$ts" );
				if( $allowedConfigAll ){
					$viewWikis = array();
					foreach( $wikis as $wiki ){
						$viewWikis[] = $skin->makeKnownLinkObj( $configTitle, $wiki, "version={$ts}&wiki={$wiki}" );
					}
					$editCore .= ' (' . implode( ', ', $viewWikis ) . ')';
				}
				$actions[] = $editCore;
			}
			if( $allowedExtensions ){
				$editExt = '';
				if( !$allowedConfig )
					$editExt .= $editMsg;
				$editExt .= $skin->makeKnownLinkObj( $extTitle, wfMsg( 'configure-edit-ext' ), "version=$ts" );
				if( $allowedExtensionsAll ){
					$viewWikis = array();
					foreach( $wikis as $wiki ){
						$viewWikis[] = $skin->makeKnownLinkObj( $extTitle, $wiki, "version={$ts}&wiki={$wiki}" );
					}
					$editExt .= ' (' . implode( ', ', $viewWikis ) . ')';
				}
				$actions[] = $editExt;
			}
			if( $showDiff ){
				$diffCheck = $c == 2 ? array( 'checked' => 'checked' ) : array();
				$versionCheck = $c == 1 ? array( 'checked' => 'checked' ) : array();
				$buttons =
					Xml::element( 'input', array_merge( 
						array( 'type' => 'radio', 'name' => 'diff', 'value' => $ts ),
						$diffCheck ) ) .
					Xml::element( 'input', array_merge(
						array( 'type' => 'radio', 'name' => 'version', 'value' => $ts ),
						$versionCheck ) );
						
			} else {
				$buttons = '';
			}
			$action = implode( ', ', $actions );
			$text .= "<li>{$buttons}{$time}: {$action}</li>\n";
		}
		$text .= "</ul>";
		if( $showDiff )
			$text .= $this->getButton() . "</form>";
		return $text;
	}

	/**
	 * Taken from PageHistory.php
	 */
	protected function getButton(){
		return Xml::submitButton( wfMsg( 'compareselectedversions' ),
				array(
					'class'     => 'historysubmit',
					'accesskey' => wfMsg( 'accesskey-compareselectedversions' ),
					'title'     => wfMsg( 'tooltip-compareselectedversions' ),
					)
				);
	}

	/**
	 * Build the content of the form
	 *
	 * @return xhtml
	 */
	protected function buildAllSettings(){
		$opt = array(
			'restrict' => false,
			'showlink' => array( '_default' => true, 'mw-extensions' => false ),
		);
		return $this->buildSettings( $this->getSettings(), $opt );
	}
}
