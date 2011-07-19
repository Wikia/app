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
		SFUtils::loadMessages();
	}

	function execute( $query ) {
		global $wgRequest;
		if ( !$this->including() )
			$this->setHeaders();
		$form_name = $this->including() ? $query : $wgRequest->getVal( 'form', $query );

		self::printPage( $form_name, $this->including() );
	}

	static function printPage( $form_name, $embedded = false ) {
		global $wgOut, $wgRequest, $sfgFormPrinter, $wgParser;

		// Get contents of form-definition page.
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		if ( ! $form_title || ! $form_title->exists() ) {
			if ( $form_name == '' ) {
				$text = Xml::element( 'p', array( 'class' => 'error' ), wfMsg( 'sf_runquery_badurl' ) ) . "\n";
			} else {
				$text = '<p class="error">Error: No form page was found at ' . SFUtils::linkText( SF_NS_FORM, $form_name ) . ".</p>\n";
			}
			$wgOut->addHTML( $text );
			return;
		}

		// Initialize variables.
		$form_article = new Article( $form_title );
		$form_definition = $form_article->getContent();
		$submit_url = $form_title->getLocalURL( 'action=submit' );
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
		// If user already made some action, ignore the edited
		// page and just get data from the query string.
		if ( !$embedded && $wgRequest->getVal( 'query' ) == 'true' ) {
			$edit_content = null;
			$is_text_source = false;
		} elseif ( $content != null ) {
			$edit_content = $content;
			$is_text_source = true;
		} else {
			$edit_content = null;
			$is_text_source = true;
		}
		list ( $form_text, $javascript_text, $data_text, $form_page_title ) =
			$sfgFormPrinter->formHTML( $form_definition, $form_submitted, $is_text_source, $form_article->getID(), $edit_content, null, null, true, $embedded );
		$text = "";

		if ( $form_submitted ) {
			global $wgUser, $wgTitle, $wgOut;
			$wgParser->mOptions = new ParserOptions();
			$wgParser->mOptions->initialiseFromUser( $wgUser );
			// @TODO - fix RunQuery's parsing so that this check
			// isn't needed.
			if ( $wgParser->getOutput() == null ) {
				$headItems = array();
			// method was added in MW 1.16
			} elseif ( method_exists( $wgParser->getOutput(), 'getHeadItems' ) ) {
				$headItems = $wgParser->getOutput()->getHeadItems();
			} else {
				$headItems = $wgParser->getOutput()->mHeadItems;
			}
			foreach ( $headItems as $key => $item ) {
				$wgOut->addHeadItem( $key, "\t\t" . $item . "\n" );
			}
		}

		// Display the text of the results.
		if ( $form_submitted ) {
			$text = $wgParser->parse( $data_text, $wgTitle, $wgParser->mOptions )->getText();
		}

		// Display the "additional query" header, if the form has
		// already been submitted.
		if ( $form_submitted ) {
			$additional_query = wfMsg( 'sf_runquery_additionalquery' );
			if ( !$raw )
				$text .= "\n<h2>$additional_query</h2>\n";
		}
		if ( !$raw ) {
			$action = htmlspecialchars( SpecialPage::getTitleFor( "RunQuery", $form_name )->getLocalURL() );
			$text .= <<<END
	<form id="sfForm" name="createbox" action="$action" method="post" class="createbox">

END;
			$text .= SFFormUtils::hiddenFieldHTML( 'query', 'true' );
			$text .= $form_text;
		}
		if ( $embedded ) {
			$text = "<div class='runQueryEmbedded'>$text</div>";
		}

		// Armor against doBlockLevels()
		$text = preg_replace( '/^ +/m', '', $text );
		// Now write everything to the screen.
		$wgOut->addHTML( $text );
		SFUtils::addJavascriptAndCSS( $embedded ? $wgParser : null );
		$script = "\t\t" . '<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n";
		if ( $embedded ) {
			$wgParser->getOutput()->addHeadItem( $script );
		} else {
			$wgOut->addScript( $script );
			if ($wgParser->getOutput()) {
				$wgOut->addParserOutputNoText( $wgParser->getOutput() );
			}
		}

		// Finally, set the page title - for MW <= 1.16, this has to be
		// called after addParserOutputNoText() for it to take effect.
		if ( !$embedded ) {
			if ( $form_page_title != null ) {
				$wgOut->setPageTitle( $form_page_title );
			} else {
				$s = wfMsg( 'sf_runquery_title', $form_title->getText() );
				$wgOut->setPageTitle( $s );
			}
		}
	}
}
