<?php
/**
 * Displays a pre-defined form for either creating a new page or editing an
 * existing one.
 *
 * @author Yaron Koren
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

class SFFormEdit extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFFormEdit() {
		SpecialPage::SpecialPage( 'FormEdit' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		global $wgRequest;

		$this->setHeaders();
		$form_name = $wgRequest->getVal( 'form' );
		$target_name = $wgRequest->getVal( 'target' );

		// if query string did not contain these variables, try the URL
		if ( ! $form_name && ! $target_name ) {
			$queryparts = explode( '/', $query, 2 );
			$form_name = isset( $queryparts[0] ) ? $queryparts[0] : '';
			$target_name = isset( $queryparts[1] ) ? $queryparts[1] : '';
		}

		$alt_forms = $wgRequest->getArray( 'alt_form' );

		self::printForm( $form_name, $target_name, $alt_forms );
	}

	static function printAltFormsList( $alt_forms, $target_name ) {
		$text = "";
		$fe = SpecialPage::getPage( 'FormEdit' );
		$fe_url = $fe->getTitle()->getFullURL();
		$i = 0;
		foreach ( $alt_forms as $alt_form ) {
			if ( $i++ > 0 ) { $text .= ", "; }
			$text .= "<a href=\"$fe_url/$alt_form/$target_name\">" . str_replace( '_', ' ', $alt_form ) . "</a>";
		}
		return $text;
	}

static function printForm( $form_name, $target_name, $alt_forms = array() ) {
	global $wgOut, $wgRequest, $wgScriptPath, $sfgScriptPath, $sfgFormPrinter, $sfgYUIBase;

	wfLoadExtensionMessages( 'SemanticForms' );

	// initialize some variables
	$target_title = null;
	$page_name_formula = null;

	// get contents of form and target page - if there's only one,
	// it might be a target with only alternate forms
	if ( $form_name == '' ) {
		$wgOut->addHTML( "<p class='error'>" . wfMsg( 'sf_formedit_badurl' ) . '</p>' );
		return;
	} elseif ( $target_name == '' ) {
		// parse the form to see if it has a 'page name' value set
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );
		$form_article = new Article( $form_title );
		$form_definition = $form_article->getContent();
		$form_definition = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $form_definition );
		$matches;
		if ( preg_match( '/{{{info.*page name=([^\|]*)/m', $form_definition, $matches ) ) {
			$page_name_formula = str_replace( '_', ' ', $matches[1] );
			// if the tag close ('}}}') is in here, chop off that
			// and everything after it
			if ( $pos = strpos( $page_name_formula, '}}}' ) ) {
				$page_name_formula = substr( $page_name_formula, 0, $pos );
			}
		} elseif ( count( $alt_forms ) == 0 ) {
			$wgOut->addWikiText( "<p class='error'>" . wfMsg( 'sf_formedit_badurl' ) . '</p>' );
			return;
		}
	}

	$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

	if ( $target_name != '' ) {
		$target_title = Title::newFromText( $target_name );
		if ( $target_title->exists() ) {
			$s = wfMsg( 'sf_formedit_edittitle', $form_title->getText(), $target_title->getPrefixedText() );
		} else {
			$s = wfMsg( 'sf_formedit_createtitle', $form_title->getText(), $target_title->getPrefixedText() );
		}
		$wgOut->setPageTitle( $s );
	}

	// handling is different depending on whether page already exists
	// or not
	if ( $target_title && $target_title->exists() ) {
                if ( $wgRequest->getVal( 'query' ) == 'true' ) {
                        $page_contents = null;
                        $page_is_source = false;
                } else {
                        $target_article = new Article( $target_title );
                        $page_contents = $target_article->getContent();
                        $page_is_source = true;
                }
	} elseif ( $target_name != '' ) {
		$target_name = str_replace( '_', ' ', $target_name );
	}

	if ( ! $form_title || ! $form_title->exists() ) {
		if ( $form_name == '' )
			$text = '<p class="error">' . wfMsg( 'sf_formedit_badurl' ) . "</p>\n";
		else {
			if ( count( $alt_forms ) > 0 ) {
				$text .= '<div class="infoMessage">' . wfMsg( 'sf_formedit_altformsonly' ) . ' ';
				$text .= self::printAltFormsList( $alt_forms, $form_name );
				$text .= "</div>\n";
			} else
				$text = '<p class="error">' . wfMsg( 'sf_formstart_badform', SFUtils::linkText( SF_NS_FORM, $form_name ) ) . ".</p>\n";
		}
	} elseif ( $target_name == '' && $page_name_formula == '' ) {
		$text = '<p class="error">' . wfMsg( 'sf_formedit_badurl' ) . "</p>\n";
	} else {
		$form_article = new Article( $form_title );
		$form_definition = $form_article->getContent();

		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		$diff_page = $wgRequest->getCheck( 'wpDiff' );
		$form_submitted = ( $save_page || $preview_page || $diff_page );
		// get 'preload' query value, if it exists
		if ( ! $form_submitted ) {
			if ( $wgRequest->getCheck( 'preload' ) ) {
				$page_is_source = true;
				$page_contents = SFFormUtils::getPreloadedText( $wgRequest->getVal( 'preload' ) );
			} else {
				// let other extensions preload the page, if they want
				wfRunHooks( 'sfEditFormPreloadText', array( &$page_contents, $target_title, $form_title ) );
				$page_is_source = ( $page_contents != null );
			}
		} else {
			$page_is_source = false;
			$page_contents = null;
		}
		list ( $form_text, $javascript_text, $data_text, $form_page_title, $generated_page_name ) =
			$sfgFormPrinter->formHTML( $form_definition, $form_submitted, $page_is_source, $form_article->getID(), $page_contents, $target_name, $page_name_formula );
		if ( $form_submitted ) {
			if ( $page_name_formula != '' ) {
				$target_name = $generated_page_name;
				// prepend a super-page, if one was specified
				if ( $wgRequest->getCheck( 'super_page' ) ) {
					$target_name = $wgRequest->getVal( 'super_page' ) . '/' . $target_name;
				}
				// prepend a namespace, if one was specified
				if ( $wgRequest->getCheck( 'namespace' ) ) {
					$target_name = $wgRequest->getVal( 'namespace' ) . ':' . $target_name;
				}
				// replace "unique number" tag with one that
				// won't get erased by the next line
				$target_name = preg_replace( '/<unique number(.*)>/', '{num\1}', $target_name, 1 );
				// if any formula stuff is still in the name
				// after the parsing, just remove it
				$target_name = StringUtils::delimiterReplace( '<', '>', '', $target_name );

				// now run the parser on it
				global $wgParser;
				// ...but first, replace spaces back with
				// underlines, in case a magic word or parser
				// function name contains underlines -
				// hopefully this won't cause problems of
				// its own
				$target_name = str_replace( ' ', '_', $target_name );
				$target_name = $wgParser->recursiveTagParse( $target_name );

				if ( strpos( $target_name, '{num' ) ) {
					// get unique number start value from
					// target name; if it's not there, or
					// it's not a positive number,
					// start it out as blank
					preg_match( '/{num.*start=([^;]*).*}/', $target_name, $matches );
					if ( count( $matches ) == 2 && is_numeric( $matches[1] ) && $matches[1] >= 0 ) {
						$title_number = $matches[1];
					} else {
						$title_number = "";
					}
					// cycle through numbers for this tag
					// until we find one that gives a
					// nonexistent page title
					do {
						$target_title = Title::newFromText( preg_replace( '/{num.*}/', $title_number, $target_name ) );
						// if title number is blank,
						// change it to 2; otherwise,
						// increment it, and if necessary
						// pad it with leading 0s as well
						if ( $title_number == "" ) {
							$title_number = 2;
						} else {
							$title_number = str_pad( $title_number + 1, strlen( $title_number ), '0', STR_PAD_LEFT );
						}
					} while ( $target_title->exists() );
				} else {
					$target_title = Title::newFromText( $target_name );
				}
			}
			if ( is_null( $target_title ) ) {
				die ( wfMsg( 'badtitle' ) . ": $target_name" );
			}
			$wgOut->setArticleBodyOnly( true );
			$text = SFUtils::printRedirectForm( $target_title, $data_text, $wgRequest->getVal( 'wpSummary' ), $save_page, $preview_page, $diff_page, $wgRequest->getCheck( 'wpMinoredit' ), $wgRequest->getCheck( 'wpWatchthis' ), $wgRequest->getVal( 'wpStarttime' ), $wgRequest->getVal( 'wpEdittime' ) );
		} else {
			// override the default title for this page if
			// a title was specified in the form
			if ( $form_page_title != null ) {
				if ( $target_name == '' ) {
					$wgOut->setPageTitle( $form_page_title );
				} else {
					$wgOut->setPageTitle( "$form_page_title: {$target_title->getPrefixedText()}" );
				}
			}
			$text = "";
			if ( count( $alt_forms ) > 0 ) {
				$text .= '<div class="infoMessage">' . wfMsg( 'sf_formedit_altforms' ) . ' ';
				$text .= self::printAltFormsList( $alt_forms, $target_name );
				$text .= "</div>\n";
			}
			$text .= <<<END
				<form name="createbox" onsubmit="return validate_all()" action="" method="post" class="createbox">

END;
			$text .= $form_text;
		}
	}
	SFUtils::addJavascriptAndCSS();
	// instead of adding the Javascript using addScript(), which is the
	// standard approach, we add it using addHTML(), below the form text -
	// that's so the Javascript created for fields with a 'show on select'
	// parameter, if there are any, get placed below the form HTML, so
	// that they can affect (i.e., hide) the relevant form fields.
	// if there's a less hacky way to do this, the code should switch to
	// that.
	// if (! empty($javascript_text))
	//	$wgOut->addScript('		<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n");
	$wgOut->addHTML( $text );
	if ( ! empty( $javascript_text ) )
		$wgOut->addHTML( '		<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n" );
}

}
