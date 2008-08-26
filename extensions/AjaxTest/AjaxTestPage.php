<?php
/**
 * Special page for AjaxTest
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class AjaxTestPage extends SpecialPage {
	
	/**
	 * Constructor
	 */
	function __construct() {
		SpecialPage::SpecialPage( 'AjaxTest', '', true );
	}
	
	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut;
		global $wgJsMimeType, $wgScriptPath;
		
		$this->setHeaders();
		
		$wgOut->addScript( 
			"<script type=\"{$wgJsMimeType}\" src=\"{$wgScriptPath}/extensions/AjaxTest/AjaxTest.js\">" .
			"</script>\n" 
		);
		
		
		$wgOut->addHtml( $this->makeInputForm() );
	}
	        
	/**
	 * Input form for entering a category
	 */
	function makeInputForm() {
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form = '';
		$form .= wfOpenElement( 'form', array( 'name' => 'ajaxtest', 'method' => 'get', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'ajaxtest_text', 'id' => 'ajaxtest_text', 'value' => '', 'size' => '64' ) ) . ' ';
		$form .= wfElement( 'br' );
		$form .= wfElement( 'label', array( 'for' => 'usestring' ), 'use string value' );
		$form .= wfElement( 'input', array( 'type' => 'checkbox', 'name' => 'usestring', 'id' => 'usestring') );
		$form .= wfElement( 'br' );
		$form .= wfElement( 'label', array( 'for' => 'httpcache' ), 'use http cache' );
		$form .= wfElement( 'input', array( 'type' => 'checkbox', 'name' => 'httpcache', 'id' => 'httpcache') );
		$form .= wfElement( 'br' );
		$form .= wfElement( 'label', array( 'for' => 'lastmod' ), 'use last modified' );
		$form .= wfElement( 'input', array( 'type' => 'checkbox', 'name' => 'lastmod', 'id' => 'lastmod') );
		$form .= wfElement( 'br' );
		$form .= wfElement( 'label', array( 'for' => 'error' ), 'trigger error' );
		$form .= wfElement( 'input', array( 'type' => 'checkbox', 'name' => 'error', 'id' => 'error') );
		$form .= wfElement( 'br' );
		$form .= wfOpenElement( 'select', array( 'name' => 'ajaxtest_target', 'id' => 'ajaxtest_target' ) );
		$form .= wfElement( 'option', array( 'value' => 'function' ), "function" );
		$form .= wfElement( 'option', array( 'value' => 'element' ), "element" );
		$form .= wfElement( 'option', array( 'value' => 'input' ), "input" );
		$form .= wfCloseElement( 'select' );
		$form .= wfElement( 'input', array( 'type' => 'button', 'onclick' => 'doAjaxTest();', 'value' => 'TEST' ) );
		$form .= wfElement( 'input', array( 'type' => 'button', 'onclick' => 'clearAjaxTest();', 'value' => 'CLEAR' ) );
		#$form .= wfElement( 'input', array( 'type' => 'button', 'onclick' => 'getElementById("ajaxtest_out").value= getElementById("ajaxtest_text").value;', 'value' => 'DUMMY' ) );
		$form .= wfCloseElement( 'form' );
		
		$form .= wfElement( 'hr' );
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'ajaxtest_out', 'id' => 'ajaxtest_out', 'value' => '', 'size' => '64' ) ) . ' ';
		$form .= wfElement( 'p', array( 'id' => 'ajaxtest_area' ) );
		$form .= wfElement( 'hr' );
		$form .= wfElement( 'p', array( 'id' => 'sajax_debug' ) );
		return $form;
	}
}


