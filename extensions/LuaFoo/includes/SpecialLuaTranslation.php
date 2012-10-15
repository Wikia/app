<?php

class LuaFoo_SpecialLuaTranslation extends SpecialPage {
	function __construct() {
		parent::__construct( 'LuaTranslation' );
	}

	function getDescription() {
		return wfMsg( 'luafoo-luatranslation' );
	}

	function execute( $par ) {
		global $wgRequest;

		$this->setHeaders();

		$form = new HTMLForm( array(
			'TitleText' => array(
				'type' => 'text',
				'label-message' => 'luafoo-convert-title',
			) ) );
		$form->setSubmitText( wfMsg( 'luafoo-convert-submit' ) );
		$form->setSubmitCallback( array( $this, 'showTranslation' ) );
		$form->setTitle( $this->getTitle() );
		$form->show();
	}

	function showTranslation( $data ) {
		global $wgOut;

		$title = Title::newFromText( $data['TitleText'], NS_TEMPLATE );
		if ( !$title ) {
			$wgOut->addHTML( wfMsg( 'badtitle' ) );
			return;
		}

		$converted = LuaFoo_Converter::convert( $title, 'lua' );
		$wgOut->addHTML( Html::element( 'pre', array(), $converted ) );
	}
}
