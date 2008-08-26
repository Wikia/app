<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page that allows authorised users to configure extensions
 *
 * @ingroup Extensions
 */
class SpecialExtensions extends ConfigurationPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Extensions', 'extensions' );
	}

	protected function getSettingMask(){
		return CONF_SETTINGS_EXT;	
	}

	/**
	 * Submit a posted form
	 */
	public function doSubmit(){
		global $wgConf, $wgOut;
		$current = $wgConf->getCurrent( $this->mWiki );
		$settings = $this->importFromRequest();
		$new = $settings + $current;
		$new['__includes'] = $this->getRequiredFiles(); 
		$ok = $wgConf->saveNewSettings( $new, $this->mWiki );
		$msg = wfMsgNoTrans( $ok ? 'configure-saved' : 'configure-error' );
		$class = $ok ? 'successbox' : 'errorbox';

		$wgOut->addWikiText( "<div class=\"$class\"><strong>$msg</strong></div>" );
	}

	/**
	 * Show the diff between the current version and the posted version
	 */
	protected function showDiff(){
		global $wgConf, $wgOut;
		$wiki = $this->mWiki;
		$old = array( $wiki => $wgConf->getCurrent( $wiki ) );
		$new = array( $wiki => $this->conf );
		$diff = new ExtPreviewConfigurationDiff( $old, $new, array( $wiki ) );
		$diff->setViewCallback( array( $this, 'userCanRead' ) );
		$wgOut->addHtml( $diff->getHtml() );
	}

	/**
	 * Get an array of files to include at each request
	 * @return array
	 */
	protected function getRequiredFiles(){
		global $wgRequest;
		$arr = array();
		foreach( $this->mConfSettings->getAllExtensionsObjects() as $ext ){
			if( $wgRequest->getCheck( $ext->getCheckName() ) )
				$arr[] = $ext->getFile();
		}
		return $arr;
	}

	/**
	 * Simple wrapper to make it public
	 */
	public function buildInput( $conf, $param = array() ){
		return parent::buildInput( $conf, $param );
	}

	/**
	 * Same as before
	 */
	public function getSettingValue( $setting ){
		return parent::getSettingValue( $setting );	
	}

	/**
	 * Build the content of the form
	 *
	 * @return xhtml
	 */
	protected function buildAllSettings(){
		$ret = '';
		$globalDone = false;
		foreach( $this->mConfSettings->getAllExtensionsObjects() as $ext ){
			$settings = $ext->getSettings();
			foreach( $settings as $setting => $type ){
				if( !isset( $GLOBALS[$setting] ) && !isset( $this->conf[$setting] ) ){
					if( !$globalDone ){
						extract( $GLOBALS, EXTR_REFS );
						$__hooks__ = $wgHooks;
						$globalDone = true;
					}
					require_once( $ext->getFile() );
					if( isset( $$setting ) )
						$this->conf[$setting] = $$setting;
				}	
			}
			$ext->setPageObj( $this );
			$ret .= $ext->getHtml();
		}
		if( isset( $__hooks__ ) )
			$GLOBALS['wgHooks'] = $__hooks__;
		return $ret;
	}
}
