<?php

/**
 *
 */
class SpecialUserDebugInfo extends SpecialPage {

	public function __construct() {
		parent::__construct( 'UserDebugInfo' );
	}

	public function execute( $subpage ) {
		$this->setHeaders();

		$out = $this->getOutput();
		$out->addHTML( Xml::openElement( 'table', array( 'class' => 'wikitable' ) ) );

		$out->addHTML( '<thead>' );
		$out->addHTML( '<tr>' );
		$out->addHTML( '<th>' );
		$out->addWikiMsg( 'userdebuginfo-key' );
		$out->addHTML( '</th>' );
		$out->addHTML( '<th>' );
		$out->addWikiMsg( 'userdebuginfo-value' );
		$out->addHTML( '</th>' );
		$out->addHTML( '</tr>' );
		$out->addHTML( '</thead>' );

		$out->addHTML( '<tbody>' );

		$this->printRow( 'userdebuginfo-useragent', htmlspecialchars( $_SERVER['HTTP_USER_AGENT'] ) );

		if ( isset( $_SERVER['REMOTE_HOST'] ) ) {
			$this->printRow( 'userdebuginfo-remotehost', $_SERVER['REMOTE_HOST'] );
		}

		$this->printRow( 'userdebuginfo-remoteaddr', wfGetIP() );
		$this->printRow( 'userdebuginfo-language', htmlspecialchars( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) );

		$out->addHTML( '</tbody>' );
		$out->addHTML( '</table>' );
	}

	/**
	 * @param $key string Message key to be converted for output
	 * @param $value string Text to output
	 */
	private function printRow( $key, $value ) {
		$out = $this->getOutput();
		$out->addHTML( '<tr>' );
		$out->addHTML( '<td>' );
		$out->addWikiMsg( $key );
		$out->addHTML( '</td>' );

		$out->addHTML( '<td>' );
		$out->addHTML( $value );
		$out->addHTML( '</td>' );

		$out->addHTML( '</tr>' );
	}
}

