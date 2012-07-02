<?php

class FastCat extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'FastCat' /*class*/ );
	}


	function execute( $par ) {
		global $wgUser, $wgOut, $wgContLang;

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
		}

		if( $wgUser->isAnon() )
			$this->errjump( 0 );

		$artid = "";
		$spice = "";
		$artname = "";
		$cat = "";

		if(isset($_POST["id"]))
			$artid = $_POST["id"];
		if(isset($_POST["spice"]))
			$spice = $_POST["spice"];
		if(isset($_POST["artname"]))
			$artname = $_POST["artname"];
		if(isset($_POST["cat"]))
			$cat = $_POST["cat"];

		if( !$spice || !$artname || !$cat)
			$this->errjump( 1 );

		# FIXME: mimic CategorySelect here
		$myspice = sha1("Kroko-katMeNot-$artid-$artname-NotMekat-Schnapp");

		if($spice != $myspice)
			$this->errjump( 2 );

		$title = Title::newFromText( $artname );
		if ( !is_object( $title ) ) 
			$this->errjump( 3 );

		$rev = Revision::newFromTitle( $title );

		$emptycat = '[[' . $wgContLang->getNsText(NS_CATEGORY) . ':' . wfMsgForContent( 'fastcat-marker-category' ) . ']]';

		if( $rev && (strstr($rev->getText(), $emptycat ))) {
			$newtext = str_replace( $emptycat, "[[" . $wgContLang->getNsText(NS_CATEGORY) . ':' . $cat . "]]", $rev->getText() );

			if(strcmp($newtext, $rev->getText())) {
				$article = new Article( $title );
				$article->updateArticle( $newtext, wfMsgForContent( 'fastcat-edit-comment', $cat ), false, false );

				$wgOut->redirect( $title->getFullUrl() );
			}
		} else {
			$this->errjump( 4 );
		}
	}

	function errjump( $num ) {
	        global $wgOut, $wgServer;

	        $wgOut->redirect( $wgServer );
	        $wgOut->output();
	        exit ( 0 );
	}

}
