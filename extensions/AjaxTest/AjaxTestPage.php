<?php
/**
 * Special page for AjaxTest
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class AjaxTestPage extends SpecialPage {
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'AjaxTest', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgOut, $wgExtensionAssetsPath;

		$this->setHeaders();

		$wgOut->addScriptFile( "$wgExtensionAssetsPath/AjaxTest/AjaxTest.js" );

		$wgOut->addHTML( $this->makeInputForm() );
	}

	/**
	 * Input form for entering a category
	 */
	function makeInputForm() {
		$form = '';
		$form .= Html::openElement( 'form', array( 'name' => 'ajaxtest', 'method' => 'GET', 'action' => $this->getTitle()->getLocalUrl() ) );
		$form .= Html::element( 'input', array( 'type' => 'text', 'name' => 'ajaxtest_text', 'id' => 'ajaxtest_text', 'value' => '', 'size' => '64' ) ) . ' ';
		$form .= Html::element( 'br' );
		$form .= Html::element( 'label', array( 'for' => 'usestring' ), 'use string value' );
		$form .= Html::element( 'input', array( 'type' => 'checkbox', 'name' => 'usestring', 'id' => 'usestring' ) );
		$form .= Html::element( 'br' );
		$form .= Html::element( 'label', array( 'for' => 'httpcache' ), 'use http cache' );
		$form .= Html::element( 'input', array( 'type' => 'checkbox', 'name' => 'httpcache', 'id' => 'httpcache' ) );
		$form .= Html::element( 'br' );
		$form .= Html::element( 'label', array( 'for' => 'lastmod' ), 'use last modified' );
		$form .= Html::element( 'input', array( 'type' => 'checkbox', 'name' => 'lastmod', 'id' => 'lastmod' ) );
		$form .= Html::element( 'br' );
		$form .= Html::element( 'label', array( 'for' => 'error' ), 'trigger error' );
		$form .= Html::element( 'input', array( 'type' => 'checkbox', 'name' => 'error', 'id' => 'error' ) );
		$form .= Html::element( 'br' );
		$form .= Html::openElement( 'select', array( 'name' => 'ajaxtest_target', 'id' => 'ajaxtest_target' ) );
		$form .= Html::element( 'option', array( 'value' => 'function' ), "function" );
		$form .= Html::element( 'option', array( 'value' => 'element' ), "element" );
		$form .= Html::element( 'option', array( 'value' => 'input' ), "input" );
		$form .= Html::closeElement( 'select' );
		$form .= Html::element( 'input', array( 'type' => 'button', 'onclick' => 'doAjaxTest();', 'value' => 'TEST' ) );
		$form .= Html::element( 'input', array( 'type' => 'button', 'onclick' => 'clearAjaxTest();', 'value' => 'CLEAR' ) );
		# $form .= Html::element( 'input', array( 'type' => 'button', 'onclick' => 'getElementById("ajaxtest_out").value= getElementById("ajaxtest_text").value;', 'value' => 'DUMMY' ) );
		$form .= Html::closeElement( 'form' );

		$form .= Html::element( 'hr' );
		$form .= Html::element( 'input', array( 'type' => 'text', 'name' => 'ajaxtest_out', 'id' => 'ajaxtest_out', 'value' => '', 'size' => '64' ) ) . ' ';
		$form .= Html::element( 'p', array( 'id' => 'ajaxtest_area' ) );
		$form .= Html::element( 'hr' );
		$form .= Html::element( 'p', array( 'id' => 'sajax_debug' ) );
		return $form;
	}
}
