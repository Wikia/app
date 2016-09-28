<?php
/**
 * Displays a pre-defined form that a user can run a query with.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFRunQuery extends IncludableSpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'RunQuery' );
	}

	function execute( $query ) {
		global $wgRequest;

		if ( !$this->including() ) {
			$this->setHeaders();
		}
		$form_name = $this->including() ? $query : $wgRequest->getVal( 'form', $query );

		$this->printPage( $form_name, $this->including() );
	}

	function printPage( $form_name, $embedded = false ) {
		global $wgOut, $wgRequest, $sfgFormPrinter, $wgParser, $sfgRunQueryFormAtTop;
		global $wgUser;

		// Get contents of form-definition page.
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		if ( !$form_title || !$form_title->exists() ) {
			if ( $form_name === '' ) {
				$text = Html::element( 'p', array( 'class' => 'error' ), wfMessage( 'sf_runquery_badurl' )->text() ) . "\n";
			} else {
				$text = Html::rawElement( 'p', array( 'class' => 'error' ),
					wfMessage( 'sf_formstart_badform', SFUtils::linkText( SF_NS_FORM, $form_name ) )->parse() ) . "\n";
			}
			$wgOut->addHTML( $text );
			return;
		}

		// Initialize variables.
		$form_definition = SFUtils::getPageText( $form_title );
		if ( $embedded ) {
			$run_query = false;
			$content = null;
			$raw = false;
		} else {
			$run_query = $wgRequest->getCheck( 'wpRunQuery' );
			$content = $wgRequest->getVal( 'wpTextbox1' );
			$raw = $wgRequest->getBool( 'raw', false );
		}
		$form_submitted = ( $run_query );
		if ( $raw ) {
			$wgOut->setArticleBodyOnly( true );
		}

		list ( $form_text, $data_text, $form_page_title ) =
			$sfgFormPrinter->formHTML( $form_definition, $form_submitted, false, $form_title->getArticleID(), $content, null, null, true, $embedded );
		$text = "";

		// Get the text of the results.
		$resultsText = '';

		if ( $form_submitted ) {

			// @TODO - fix RunQuery's parsing so that this check
			// isn't needed.
			if ( $wgParser->getOutput() == null ) {
				$headItems = array();
			} else {
				$headItems = $wgParser->getOutput()->getHeadItems();
			}
			foreach ( $headItems as $key => $item ) {
				$wgOut->addHeadItem( $key, "\t\t" . $item . "\n" );
			}

			$wgParser->mOptions = ParserOptions::newFromUser( $wgUser );
			$resultsText = $wgParser->parse( $data_text, $this->getTitle(), $wgParser->mOptions )->getText();
		}

		// Get the full text of the form.
		$fullFormText = '';
		$additionalQueryHeader = '';
		$dividerText = '';
		if ( !$raw ) {
			// Create the "additional query" header, and the
			// divider text - one of these (depending on whether
			// the query form is at the top or bottom) is displayed
			// if the form has already been submitted.
			if ( $form_submitted ) {
				$additionalQueryHeader = "\n" . Html::element( 'h2', null, wfMessage( 'sf_runquery_additionalquery' )->text() ) . "\n";
				$dividerText = "\n<hr style=\"margin: 15px 0;\" />\n";
			}
			$action = htmlspecialchars( $this->getTitle( $form_name )->getLocalURL() );
			$fullFormText .= <<<END
	<form id="sfForm" name="createbox" action="$action" method="post" class="createbox">

END;
			$fullFormText .= Html::hidden( 'query', 'true' );
			$fullFormText .= $form_text;
		}

		// Either don't display a query form at all, or display the
		// query form at the top, and the results at the bottom, or the
		// other way around, depending on the settings.
		if ( $wgRequest->getVal( 'additionalquery' ) == 'false' ) {
			$text .= $resultsText;
		} elseif ( $sfgRunQueryFormAtTop ) {
			$text .= Html::openElement( 'div', array( 'class' => 'sf-runquery-formcontent' ) );
			$text .= $fullFormText;
			$text .= $dividerText;
			$text .= Html::closeElement( 'div' );
			$text .= $resultsText;
		} else {
			$text .= $resultsText;
			$text .= Html::openElement( 'div', array( 'class' => 'sf-runquery-formcontent' ) );
			$text .= $additionalQueryHeader;
			$text .= $fullFormText;
			$text .= Html::closeElement( 'div' );
		}

		if ( $embedded ) {
			$text = "<div class='runQueryEmbedded'>$text</div>";
		}

		// Armor against doBlockLevels()
		$text = preg_replace( '/^ +/m', '', $text );

		// Now write everything to the screen.
		$wgOut->addHTML( $text );
		SFUtils::addFormRLModules( $embedded ? $wgParser : null );
		if ( !$embedded ) {
			$po = $wgParser->getOutput();
			if ( $po ) {
				// addParserOutputMetadata was introduced in 1.24 when addParserOutputNoText was deprecated
				if( method_exists( $wgOut, 'addParserOutputMetadata' ) ){
					$wgOut->addParserOutputMetadata( $po );
				} else {
					$wgOut->addParserOutputNoText( $po );
				}
			}
		}

		// Finally, set the page title - previously, this had to be
		// called after addParserOutputNoText() for it to take effect;
		// now the order doesn't matter.
		if ( !$embedded ) {
			if ( $form_page_title != null ) {
				$wgOut->setPageTitle( $form_page_title );
			} else {
				$s = wfMessage( 'sf_runquery_title', $form_title->getText() )->text();
				$wgOut->setPageTitle( $s );
			}
		}
	}

	protected function getGroupName() {
		return 'sf_group';
	}
}
