<?php
/**
 * Special:ThemeDesigner implementation for extension ThemeDesigner
 *
 * @file
 * @ingroup Extensions
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}

class ThemeDesignerDummySkin extends Skin {
	
	function __construct() {
		parent::__construct();
		$this->setMembers();
	}
	
	function commonPrintStylesheet() {
		return false;
	}
	
	function setupUserCss( OutputPage $out ) {
		
		foreach ( $out->getExtStyle() as $url ) {
			$out->addStyle( $url );
		}
		
	}
	
}

class SpecialThemeDesigner extends SpecialPage {
	
	public function __construct() {
		parent::__construct( 'ThemeDesigner' );
	}
	
	/**
	 * Show the special page
	 *
	 * @param $par String: name of the user to sudo into
	 */
	public function execute( $par ) {
		global $wgOut, $wgExtensionAssetsPath;
		
		$this->mSkin = new ThemeDesignerDummySkin;
		
		$this->setHeaders();
		
		if ( function_exists("OutputPage::includeJQuery") ) {
			$wgOut->includeJQuery();
		}
		
		$wgOut->addExtensionStyle("$wgExtensionAssetsPath/ThemeDesigner/frame/style/main.css");
		// Yes, the following is ugly... though I still haven't decided if I want to become completely ResourceLoader dependant
		// While 1.16 is still stable.
		$varScript = array();
		foreach ( array('leavewarning', 'resizertext') as $msgName ) {
			$varScript[] = 'msg'.ucfirst($msgName).' = '.Xml::encodeJsVar((string)wfMsg("themedesigner-{$msgName}"));
		}
		$varScript = 'var '.implode(", ", $varScript).';';
		$wgOut->addInlineScript($varScript);
		$wgOut->addScriptFile("$wgExtensionAssetsPath/ThemeDesigner/frame/designer.js");
		
		echo $wgOut->headElement( $this->mSkin );
		$wgOut->sendCacheControl();
		$wgOut->disable();
		
		// We've collected our html building into a separate file for readability
		require(dirname(__FILE__).'/frame/layout.php');
		
		echo $this->mSkin->bottomScripts( $wgOut );
		echo Html::closeElement('body');
		echo Html::closeElement('html');
		
	}
	
}
