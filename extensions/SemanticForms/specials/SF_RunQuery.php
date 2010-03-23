<?php
/**
 * Displays a pre-defined form that a user can run a query with.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFRunQuery extends IncludableSpecialPage {

	/**
	 * Constructor
	 */
	function SFRunQuery() {
		parent::__construct( 'RunQuery' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		global $wgRequest;
		if ( !$this->including() )
			$this->setHeaders();
		$form_name = $this->including() ? $query : $wgRequest->getVal( 'form', $query );

		self::printQueryForm( $form_name, $this->including() );
	}

	static function printQueryForm( $form_name, $embedded = false ) {
		global $wgOut, $wgRequest, $wgScriptPath, $sfgScriptPath, $sfgFormPrinter, $sfgYUIBase, $wgParser;

		// get contents of form definition file
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		if ( ! $form_title || ! $form_title->exists() ) {
			$javascript_text = "";
			if ( $form_name == '' )
				$text = '<p class="error">' . wfMsg( 'sf_runquery_badurl' ) . "</p>\n";
			else
				$text = '<p class="error">Error: No form page was found at ' . SFUtils::linkText( SF_NS_FORM, $form_name ) . ".</p>\n";
		} else {
			$s = wfMsg( 'sf_runquery_title', $form_title->getText() );
			if ( !$embedded )
				$wgOut->setPageTitle( $s );
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
			if ( $raw )
				$wgOut->setArticleBodyOnly( true );
			// if user already made some action, ignore the edited
			// page and just get data from the query string
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
			// override the default title for this page if
			// a title was specified in the form
			if ( $form_page_title != null && !$embedded ) {
				$wgOut->setPageTitle( $form_page_title );
			}
			if ( $form_submitted ) {
				global $wgUser, $wgTitle;
				$wgParser->mOptions = new ParserOptions();
				$wgParser->mOptions->initialiseFromUser( $wgUser );
				$text = $wgParser->parse( $data_text, $wgTitle, $wgParser->mOptions )->getText();
				$additional_query = wfMsg( 'sf_runquery_additionalquery' );
				if ( !$raw )
					$text .= "\n<h2>$additional_query</h2>\n";
			}
			if ( !$raw ) {
				$action = htmlspecialchars( SpecialPage::getTitleFor( "RunQuery", $form_name )->getLocalURL() );
				$text .= <<<END
	<form name="createbox" onsubmit="return validate_all()" action="$action" method="post" class="createbox">
	<input type="hidden" name="query" value="true" />

END;
				$text .= $form_text;
			}
		}
		SFUtils::addJavascriptAndCSS( $embedded ? $wgParser:null );
		$script = '		<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n";
		if ( $embedded )
			$wgParser->getOutput()->addHeadItem( $script );
		else
			$wgOut->addScript( $script );
		if ( $embedded )
			$text = "<div class='runQueryEmbedded'>$text</div>";
		$wgOut->addHTML( $text );
	}
}
