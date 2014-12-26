<?php

class ExpandTemplates extends SpecialPage {
	var $generateXML, $removeComments, $removeNowiki, $isNewParser;

	/* 50MB allows fixing those huge pages */
	const MAX_INCLUDE_SIZE = 50000000;

	function __construct() {
		parent::__construct( 'ExpandTemplates' );
	}

	function execute( $subpage ) {
		global $wgRequest, $wgParser, $wgOut;

		$this->setHeaders();

		$this->isNewParser = is_callable( array( $wgParser, 'preprocessToDom' ) );

		$titleStr = $wgRequest->getText( 'contexttitle' );
		$title = Title::newFromText( $titleStr );
		$selfTitle = $this->getTitle();
		if ( !$title ) {
			$title = $selfTitle;
		}
		$input = $wgRequest->getText( 'input' );
		$this->generateXML = $this->isNewParser ? $wgRequest->getBool( 'generate_xml' ) : false;
		if ( strlen( $input ) ) {
			$this->removeComments = $wgRequest->getBool( 'removecomments', false );
			$this->removeNowiki = $wgRequest->getBool( 'removenowiki', false );
			$options = new ParserOptions;
			$options->setRemoveComments( $this->removeComments );
			$options->setTidy( true );
			$options->setMaxIncludeSize( self::MAX_INCLUDE_SIZE );
			if ( $this->generateXML ) {
				$wgParser->startExternalParse( $title, $options, OT_PREPROCESS );
				$dom = $wgParser->preprocessToDom( $input );
				if ( is_callable( array( $dom, 'saveXML' ) ) ) {
					$xml = $dom->saveXML();
				} else {
					$xml = $dom->__toString();
				}
			}
			$output = $wgParser->preprocess( $input, $title, $options );
		} else {
			$this->removeComments = $wgRequest->getBool( 'removecomments', true );
			$this->removeNowiki = $wgRequest->getBool( 'removenowiki', false );
			$output = false;
		}

		$wgOut->addWikiText( wfMsg( 'expand_templates_intro' ) );
		$wgOut->addHTML( $this->makeForm( $titleStr, $input ) );

		if( $output !== false ) {
			global $wgUseTidy, $wgAlwaysUseTidy;

			if ( $this->generateXML ) {
				$wgOut->addHTML( $this->makeOutput( $xml, 'expand_templates_xml_output' ) );
			}
			$tmp = $this->makeOutput( $output );
			if ( $this->removeNowiki ) {
				$tmp = preg_replace( array( '_&lt;nowiki&gt;_', '_&lt;/nowiki&gt;_', '_&lt;nowiki */&gt;_' ), '', $tmp );
			}
			if( ( $wgUseTidy && $options->getTidy() ) || $wgAlwaysUseTidy ) {
				$tmp = MWTidy::tidy( $tmp );
			}
			$wgOut->addHTML( $tmp );
			$this->showHtmlPreview( $title, $output, $wgOut );
		}

	}

	/**
	 * Generate a form allowing users to enter information
	 *
	 * @param $title Value for context title field
	 * @param $input Value for input textbox
	 * @return string
	 */
	private function makeForm( $title, $input ) {
		global $wgUser;
		$self = $this->getTitle();
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= "<fieldset><legend>" . wfMsgHtml( 'expandtemplates' ) . "</legend>\n";
		$form .= '<p>' . Xml::inputLabel( wfMsgNoTrans( 'expand_templates_title' ), 'contexttitle', 'contexttitle', 60, $title ) . '</p>';
		$form .= '<p>' . Xml::label( wfMsg( 'expand_templates_input' ), 'input' ) . '</p>';
		$form .= Xml::openElement( 'textarea', array( 'name' => 'input', 'id' => 'input', 'rows' => 10, 'cols' => 10 ) );
		$form .= htmlspecialchars( $input );
		$form .= Xml::closeElement( 'textarea' );
		$form .= '<p>' . Xml::checkLabel( wfMsg( 'expand_templates_remove_comments' ), 'removecomments', 'removecomments', $this->removeComments ) . '</p>';
		$form .= '<p>' . Xml::checkLabel( wfMsg( 'expand_templates_remove_nowiki' ), 'removenowiki', 'removenowiki', $this->removeNowiki ) . '</p>';
		if ( $this->isNewParser ) {
			$form .= '<p>' . Xml::checkLabel( wfMsg( 'expand_templates_generate_xml' ), 'generate_xml', 'generate_xml', $this->generateXML ) . '</p>';
		}
		$form .= '<p>' . Xml::submitButton( wfMsg( 'expand_templates_ok' ), array( 'accesskey' => 's' ) ) . '</p>';
		$form .= "</fieldset>\n";
		$form .= Html::hidden( 'wpEditToken', $wgUser->getEditToken() );
		$form .= Xml::closeElement( 'form' );
		return $form;
	}

	/**
	 * Generate a nice little box with a heading for output
	 *
	 * @param $output Wiki text output
	 * @return string
	 */
	private function makeOutput( $output, $heading = 'expand_templates_output' ) {
		$out  = "<h2>" . wfMsgHtml( $heading ) . "</h2>\n";
		$out .= Xml::openElement( 'textarea', array( 'id' => 'output', 'rows' => 10, 'cols' => 10, 'readonly' => 'readonly' ) );
		$out .= htmlspecialchars( $output );
		$out .= Xml::closeElement( 'textarea' );
		return $out;
	}

	/**
	 * Render the supplied wiki text and append to the page as a preview
	 *
	 * @param Title $title
	 * @param string $text
	 * @param OutputPage $out
	 */
	private function showHtmlPreview( $title, $text, $out ) {
		global $wgParser;
		$pout = $wgParser->parse( $text, $title, new ParserOptions() );
		$out->addHTML( "<h2>" . wfMsgHtml( 'expand_templates_preview' ) . "</h2>\n" );

		global $wgRawHtml, $wgRequest, $wgUser;
		if ( $wgRawHtml ) {
			// To prevent cross-site scripting attacks, don't show the preview if raw HTML is
			// allowed and a valid edit token is not provided (bug 71111). However, MediaWiki
			// does not currently provide logged-out users with CSRF protection; in that case,
			// do not show the preview unless anonymous editing is allowed.
			if ( $wgUser->isAnon() && !$wgUser->isAllowed( 'edit' ) ) {
				$error = array( 'expand_templates_preview_fail_html_anon' );
			} elseif ( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$error = array( 'expand_templates_preview_fail_html' );
			} else {
				$error = false;
			}

			if ( $error ) {
				$out->wrapWikiMsg( "<div class='previewnote'>\n$1\n</div>", $error );
				return;
			}
		}

		$out->addHTML( $pout->getText() );
	}

}
