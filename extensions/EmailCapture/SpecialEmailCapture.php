<?php

class SpecialEmailCapture extends SpecialPage {

	public function __construct() {
		parent::__construct( 'EmailCapture', 'emailcapture' );
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest;

		$this->setHeaders();

		$code = $wgRequest->getVal( 'verify' );
		if ( $code !== null ) {
			$dbw = wfGetDB( DB_MASTER );
			$row = $dbw->selectRow(
				'email_capture',
				array( 'ec_verified' ),
				array( 'ec_code' => $code ),
				__METHOD__
			);
			if ( $row && !$row->ec_verified ) {
				$dbw->update(
					'email_capture',
					array( 'ec_verified' => 1 ),
					array( 'ec_code' => $code ),
					__METHOD__
				);
				if ( $dbw->affectedRows() ) {
					$wgOut->addWikiMsg( 'emailcapture-success' );
				} else {
					$wgOut->addWikiMsg( 'emailcapture-failure' );
				}
			} elseif ( $row && $row->ec_verified ) {
				$wgOut->addWikiMsg( 'emailcapture-already-confirmed' );
			} else {
				$wgOut->addWikiMsg( 'emailcapture-invalid-code' );
			}
		} else {
			// Show simple form for submitting verification code
			$o = Html::openElement( 'form', array(
				'action' => $this->getTitle()->getFullUrl(),
				'method' => 'post'
			) );
			$o .= Html::element( 'p', array(), wfMsg( 'emailcapture-instructions' ) );
			$o .= Html::openElement( 'blockquote' );
			$o .= Html::element( 'label', array( 'for' => 'emailcapture-verify' ),
				wfMsg( 'emailcapture-verify' ) ) . ' ';
			$o .= Html::input( 'verify', '', 'text',
				array( 'id' => 'emailcapture-verify', 'size' => 32 ) ) . ' ';
			$o .= Html::input( 'submit', wfMsg( 'emailcapture-submit' ), 'submit' );
			$o .= Html::closeElement( 'blockquote' );
			$o .= Html::closeElement( 'form' );
			$wgOut->addHtml( $o );
		}
	}
}
