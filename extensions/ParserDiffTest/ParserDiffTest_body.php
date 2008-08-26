<?php
class ParserDiffTest extends SpecialPage
{
	function ParserDiffTest() {
		wfLoadExtensionMessages( 'ParserDiffTest' );
		SpecialPage::SpecialPage("ParserDiffTest");
	}

	function execute( $subpage ) {
		global $wgRequest, $wgOut, $wgPDT_OldConf, $wgPDT_NewConf;

		$this->setHeaders();

		$getText = $wgRequest->getBool( 'pdt_get_text' );
		if ( $getText ) {
			$subpage = $wgRequest->getText( 'pdt_title' );
		}

		if ( strval( $subpage ) === '' ) {
			$title = Title::newFromText( $wgRequest->getVal( 'pdt_title' ) );
			if ( !$title ) {
				$title = Title::newMainPage();
			}
			$text = $wgRequest->getVal( 'pdt_input' );
			$this->showForm( $title->getPrefixedText(), $text );
			$comparing = '';
		} else {
			$title = Title::newFromText( $subpage );
			if ( !$title ) {
				$wgOut->addWikiText( wfMsg( 'pdtest_no_target' ) );
				return;
			}

			if ( !$title->userCanRead() ) {
				$wgOut->addWikiText( wfMsg( 'pdtest_access_denied' ) );
				return;
			}

			$revision = Revision::newFromTitle( $title );
			$text = $revision ? $revision->getText() : false;
			if ( $text === false ){
				$wgOut->addWikiText( wfMsg( 'pdtest_page_missing' ) );
				return;
			}

			$comparing = wfMsg( 'pdt_comparing_page', htmlspecialchars( $title->getPrefixedText() ) );
		}

		$oldClass = $wgPDT_OldConf['class'];
		$newClass = $wgPDT_NewConf['class'];
		$oldParser = new $oldClass( $wgPDT_OldConf );
		$newParser = new $newClass( $wgPDT_NewConf );


		$oldParser->firstCallInit();
		$newParser->firstCallInit();

		if ( $wgRequest->getBool( 'timing' ) ) {
			// Preload caches
			$newResult = $this->parse( $newParser, $text, $title );
			$oldResult = $this->parse( $oldParser, $text, $title );

			// Timing run
			$oldTime = -microtime( true );
			$oldResult = $this->parse( $oldParser, $text, $title );
			$oldTime += microtime( true );

			$newTime = -microtime( true );
			$newResult = $this->parse( $newParser, $text, $title );
			$newTime += microtime( true );
			$timeReport = wfMsg( 'pdtest_time_report', 
				$oldClass, sprintf( "%.3f", $oldTime ), $newClass, sprintf( "%.3f", $newTime ) );
		} else {
			$newResult = $this->parse( $newParser, $text, $title );
			$oldResult = $this->parse( $oldParser, $text, $title );
			$timeReport = '';
		}

		if ( $oldResult === $newResult ) {
			$diff = wfMsgHtml( 'pdtest_no_changes' );
		} else {
			$diffEngine = new DifferenceEngine;
			$diffEngine->showDiffStyle();
			$diffBody = $diffEngine->generateDiffBody( $oldResult, $newResult );
			$diff = DifferenceEngine::addHeader( $diffBody, "<strong>$oldClass</strong>", "<strong>$newClass</strong>" );
		}

		$sideBySide = '<table class="wikitable" width="100%">' . 
			'<col width="50%"/>' . 
			'<col width="50%"/>' . 
			'<tr><th>' . htmlspecialchars( $oldClass ) . '</th>' . 
			'<th>' . htmlspecialchars( $newClass ) . '</th></tr>' .
			'<tr>' .
			'<td><div style="overflow: auto">' . $oldResult . '</div></td>' . 
			'<td><div style="overflow: auto">' . $newResult . '</div></td>' . 
			'</tr></table>';

		
		$wgOut->addHTML( 
			"<div class='pdt-comparing'>$comparing</div>\n" .
			"<div class='pdt-time-report'>$timeReport</div>\n" .
			"<h2>" . wfMsgHtml( 'pdtest_diff' ) . "</h2>\n" . 
			"<div class='pdt-diff'>$diff</div>\n" . 
			( $sideBySide ? ( 
				"<h2>" . wfMsgHtml( 'pdtest_side_by_side' ) . "</h2>\n" . 
				"<div class='pdt-side-by-side'>$sideBySide</div>\n"
			) : '' )
		);
	}

	function parse( $parser, $text, $title ) {
		$options = new ParserOptions;
		$options->setTidy( true );
		$options->setEditSection( true );
		$output = $parser->parse( $text, $title, $options );
		return $output->getText();
	}

	function showForm( $title, $text ) {
		global $wgOut;

		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl() ) );
		$form .= "<fieldset>\n";
		$form .= '<p>' . Xml::inputLabel( wfMsgNoTrans( 'pdtest_title' ), 'pdt_title', 'pdt_title', 60, $title ) . '</p>';
		$form .= '<p>' . Xml::label( wfMsg( 'pdtest_text' ), 'pdt_input' ) . '</p>';
		$form .= Xml::openElement( 'textarea', array( 'name' => 'pdt_input', 'id' => 'pdt_input', 'rows' => 10, 'cols' => 10 ) );
		$form .= htmlspecialchars( $text );
		$form .= Xml::closeElement( 'textarea' );
		$form .= '<p>' . Xml::submitButton( wfMsg( 'pdtest_ok' ) ) . '&nbsp;&nbsp;' . 
		   Xml::submitButton( wfMsg( 'pdtest_get_text' ), array( 'name' => 'pdt_get_text' ) ) . '</p>';
		$form .= "</fieldset>\n";
		$form .= Xml::closeElement( 'form' );
		$wgOut->addHTML( $form );
	}
}

