<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class SpecialCreatePage extends SpecialPage {

	function __construct() {
		SpecialPage::SpecialPage( 'CreatePage', 'createpage' );
	}

	public function execute( $params ) {
		global $wgOut, $wgRequest, $wgUser;

		wfLoadExtensionMessages( 'CreatePage' );

		$this->setHeaders();
		
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$skin = $wgUser->getSkin();

		$thisPage = Title::newFromText ( "CreatePage", NS_SPECIAL );

		$target = $wgRequest->getVal ( "target" );

		// check to see if we are trying to create a page
		$title = Title::newFromText ( $target );
		// check for no title
		if ( $wgRequest->wasPosted() && $target === '' ) {
			$this->error( wfMsg( 'createpage_entertitle' ) );
		}
		// check for invalid title
		elseif ( $wgRequest->wasPosted() && is_null( $title ) ) {
			$this->error( wfMsg( 'createpage-badtitle', $target ) );
		}
		elseif ( $target != null ) {
			if ( $title->getArticleID() > 0 ) {

				// if the title exists then let the user know and give other options
				$wgOut->addWikiText ( wfMsg ( "createpage_titleexists", $title->getFullText() ) . "<br />" );
				$editlink = $skin->makeLinkObj( $title, wfMsg ( "createpage_editexisting" ), 'action=edit' );
				$wgOut->addHTML ( $editlink . '<br />'
					. $skin->makeLinkObj ( $thisPage, wfMsg ( "createpage_tryagain" ) )
				);
				return;
			} else {
				/* TODO - may want to search for closely named pages and give
				 * other options here... */

				// otherwise, redirect them to the edit page for their title
				$wgOut->redirect ( $title->getEditURL() );
			}
		}

		// if this is just a normal GET, then output the form

		// prefill the input with the title, if it was passed along
		$newTitle = false;
		$newTitleText = $wgRequest->getVal( "newtitle", null );
		if ( $newTitleText != null ) {
			$newTitle = Title::newFromURL( $newTitleText );
			if ( is_null( $newTitle) )
				$newTitle = $newTitleText;
			else
				$newTitle = $newTitle->getText();
		}

		// output the form
		$form = Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'createpage' ) ) . # This should really use a different message
			wfMsgWikiHtml( 'createpage_instructions' ) . 
			Xml::openElement( 'form', array('method'=>'post', 'name'=>'createpageform', 'action'=>'' ) ) .
			Xml::element( 'input', array('type'=>'text', 'name'=>'target', 'size'=>50, 'value'=> $newTitle ) ) .
			'<br />' .
			Xml::element( 'input', array('type'=>'submit', 'value'=> wfMsgHtml( 'createpage_submitbutton' ) ) ) .
			Xml::closeElement( 'form' ) .
			Xml::closeElement( 'fieldset' );
		$wgOut->addHTML( $form );
	}
	/*
	 * Function to output an error message
	 * @param $msg String: message text or HTML
	*/	
	function error( $msg ) {
		global $wgOut;
		$wgOut->addHTML( Xml::element('p', array( 'class' => 'error' ), $msg ) );
	}
}
