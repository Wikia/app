<?php
/**
 * Displays a pre-defined form for either creating a new page or editing an
 * existing one.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFFormEdit extends SpecialPage {

	public $mTarget;
	public $mForm;
	public $mError;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'FormEdit' );
	}

	function execute( $query, $redirectOnError = true ) {
		global $wgRequest, $wgOut;

		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mForm = $wgRequest->getText( 'form' );
		$this->mTarget = $wgRequest->getText( 'target' );

		// if query string did not contain these variables, try the URL
		if ( ! $this->mForm && ! $this->mTarget ) {
			$queryparts = explode( '/', $query, 2 );
			$this->mForm = isset( $queryparts[0] ) ? $queryparts[0] : '';
			$this->mTarget = isset( $queryparts[1] ) ? $queryparts[1] : '';
		}
		wfRunHooks( 'sfSetTargetName', array( &$this->mTarget, $query ) );

		$alt_forms = $wgRequest->getArray( 'alt_form' );

		$msg = self::printForm( $this->mForm, $this->mTarget, $alt_forms, $redirectOnError );

		if ( $msg ) {
			// some error occurred

			$msgdata = null;

			if ( is_array( $msg ) ) {
				if ( count( $msg ) > 1 ) {
					$msgdata = $msg[ 1 ];
				}
				$msg = $msg[ 0 ];
			}

			$this->mError = wfMsg( $msg, $msgdata );

			$wgOut->addHTML( Html::element( 'p', array( 'class' => 'error' ), $this->mError ) );

		} else {
			$this->mError = null;
		}
		
		wfProfileOut( __METHOD__ );

	}

	static function printAltFormsList( $alt_forms, $target_name ) {
		$text = "";
		$fe = SFUtils::getSpecialPage( 'FormEdit' );
		$fe_url = $fe->getTitle()->getFullURL();
		$i = 0;
		foreach ( $alt_forms as $alt_form ) {
			if ( $i++ > 0 ) { $text .= ', '; }
			$text .= "<a href=\"$fe_url/$alt_form/$target_name\">" . str_replace( '_', ' ', $alt_form ) . '</a>';
		}
		return $text;
	}

	static function makeRandomNumber( $numDigits, $hasPadding ) {
		$maxValue = pow( 10, $numDigits ) - 1;
		if ( $maxValue > getrandmax() ) {
			$maxValue = getrandmax();
		}
		$value = rand( 0, $maxValue );
		$format = '%' . ($hasPadding ? '0' : '') . $numDigits . 'd';
		return trim( sprintf( $format, $value ) ); // trim needed, when $hasPadding == false
	}

	static function printForm( &$form_name, &$target_name, $alt_forms = array(), $redirectOnError = false ) {
		global $wgOut, $wgRequest, $wgUser, $sfgFormPrinter;
		wfProfileIn( __METHOD__ );

		// initialize some variables
		$target_title = null;
		$page_name_formula = null;

		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		// If the given form is not a valid title, bail out.
		if ( !$form_title ) {
			wfProfileOut( __METHOD__ );
			return 'sf_formedit_badurl';
		}
		$form_article = new Article( $form_title, 0 );
		$form_definition = $form_article->getContent();

		// If the form page is a redirect, use the other form
		// instead.
		if ( $form_title->isRedirect() ) {
			$form_title = Title::newFromRedirectRecurse( $form_definition );
			$form_article = new Article( $form_title, 0 );
			$form_definition = $form_article->getContent();
		}

		$form_definition = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $form_definition );

		if ( is_null( $target_name ) ) {
			$target_name = '';
		}

		if ( $target_name === '' ) {

			// parse the form to see if it has a 'page name' value set
			$matches;
			if ( preg_match( '/{{{info.*page name\s*=\s*(.*)}}}/m', $form_definition, $matches ) ) {
				$page_name_elements = SFUtils::getFormTagComponents( $matches[1] );
				$page_name_formula = $page_name_elements[0];
			} elseif ( count( $alt_forms ) == 0 ) {
				wfProfileOut( __METHOD__ );
				return 'sf_formedit_badurl';
			}
		} else {
			$target_title = Title::newFromText( $target_name );

			if ( $target_title && $target_title->exists() ) {
				if ( $wgRequest->getVal( 'query' ) == 'true' ) {
					$page_contents = null;
					//$page_is_source = false;
				} else {
					// If page already exists and 'redlink'
					// is in the query string, redirect to
					// the actual page, just like
					// MediaWiki does it.
					if ( $wgRequest->getBool( 'redlink' ) ) {
						$wgOut->redirect( $target_title->getFullURL() );
						wfProfileOut( __METHOD__ );
						return;
					}
					$target_article = new Article( $target_title, 0 );
					$page_contents = $target_article->getContent();
					//$page_is_source = true;
				}
			} else {
				$target_name = str_replace( '_', ' ', $target_name );
			}

		}

		if ( ! $form_title || ! $form_title->exists() ) {
			if ( count( $alt_forms ) > 0 ) {

				$text = '<div class="infoMessage">'
					. wfMsg( 'sf_formedit_altformsonly' ) . ' '
					. self::printAltFormsList( $alt_forms, $form_name )
					. "</div>\n";

			} else {
				$text = Html::rawElement( 'p', array( 'class' => 'error' ), wfMsgExt( 'sf_formstart_badform', 'parseinline', SFUtils::linkText( SF_NS_FORM, $form_name ) ) ) . "\n";
			}
		} elseif ( $target_name === '' && $page_name_formula === '' ) {
			$text = Html::element( 'p', array( 'class' => 'error' ), wfMsg( 'sf_formedit_badurl' ) ) . "\n";
		} else {

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

			// Before we do anything else, set the form header
			// title - this needs to be done after formHTML() is
			// called, because otherwise it doesn't take hold
			// for some reason if the form is disabled.
			if ( empty( $target_title ) ) {
				$s = wfMsg( 'sf_formedit_createtitlenotarget', $form_title->getText() );
			} elseif ( $target_title->exists() ) {
				$s = wfMsg( 'sf_formedit_edittitle', $form_title->getText(), $target_title->getPrefixedText() );
			} else {
				$s = wfMsg( 'sf_formedit_createtitle', $form_title->getText(), $target_title->getPrefixedText() );
			}
			$wgOut->setPageTitle( $s );

			if ( $form_submitted ) {
				if ( !is_null( $page_name_formula ) && $page_name_formula !== '' ) {
					$target_name = $generated_page_name;
					// prepend a super-page, if one was specified
					if ( $wgRequest->getCheck( 'super_page' ) ) {
						$target_name = $wgRequest->getVal( 'super_page' ) . '/' . $target_name;
					}
					// prepend a namespace, if one was specified
					if ( $wgRequest->getCheck( 'namespace' ) ) {
						$target_name = $wgRequest->getVal( 'namespace' ) . ':' . $target_name;
					}
					// replace "unique number" tag with one
					// that won't get erased by the next line
					$target_name = preg_replace( '/<unique number(.*)>/', '{num\1}', $target_name, 1 );
					// if any formula stuff is still in the
					// name after the parsing, just remove it
					$target_name = StringUtils::delimiterReplace( '<', '>', '', $target_name );

					// now run the parser on it
					global $wgParser;
					// ...but first, replace spaces back
					// with underlines, in case a magic word
					// or parser function name contains
					// underlines - hopefully this won't
					// cause problems of its own
					$target_name = str_replace( ' ', '_', $target_name );
					$target_name = $wgParser->preprocess( $target_name, $wgOut->getTitle(), ParserOptions::newFromUser( null ) );

					$title_number = "";
					$isRandom = false;
					$randomNumHasPadding = false;
					$randomNumDigits = 6;

					if ( strpos( $target_name, '{num' ) !== false ) {

						// Random number
						if ( preg_match( '/{num;random(;(0)?([1-9][0-9]*))?}/', $target_name, $matches ) ) {
							$isRandom = true;
							$randomNumHasPadding = array_key_exists( 2, $matches );
							$randomNumDigits = ( array_key_exists( 3, $matches ) ? $matches[3] : $randomNumDigits );
							$title_number = self::makeRandomNumber( $randomNumDigits, $randomNumHasPadding );
						} else {
							// get unique number start value
							// from target name; if it's not
							// there, or it's not a positive
							// number, start it out as blank
							preg_match( '/{num.*start[_]*=[_]*([^;]*).*}/', $target_name, $matches );
							if ( count( $matches ) == 2 && is_numeric( $matches[ 1 ] ) && $matches[ 1 ] >= 0 ) {
								// the "start" value"
								$title_number = $matches[ 1 ];
							}

						}

						// set target title
						$target_title = Title::newFromText( preg_replace( '/{num.*}/', $title_number, $target_name ) );

						// if title exists already
						// cycle through numbers for
						// this tag until we find one
						// that gives a nonexistent page
						// title
						while ( $target_title->exists() ) {

							if ( $isRandom ) {
								$title_number = self::makeRandomNumber( $randomNumDigits, $randomNumHasPadding );
							}
							// if title number is blank,
							// change it to 2; otherwise,
							// increment it, and if necessary
							// pad it with leading 0s as well
							elseif ( $title_number == "" ) {
								$title_number = 2;
							} else {
								$title_number = str_pad( $title_number + 1, strlen( $title_number ), '0', STR_PAD_LEFT );
							}

							$target_title = Title::newFromText( preg_replace( '/{num.*}/', $title_number, $target_name ) );
						}

						$target_name = $target_title->getPrefixedText();

					} else {
						$target_title = Title::newFromText( $target_name );
					}
				}

				if ( is_null( $target_title ) ) {
					if ( $target_name )	{
						wfProfileOut( __METHOD__ );
						return array ( 'sf_formstart_badtitle' , array( $target_name ) );
					}
					else {
						wfProfileOut( __METHOD__ );
						return 'sf_formedit_emptytitle';
					}
				}

				if ( $save_page ) {

					$permErrors = $target_title->getUserPermissionsErrors( 'edit', $wgUser );
					if ( $permErrors ) {
						// just return the first error and let them fix it one by one
						wfProfileOut( __METHOD__ );
						return array_shift( $permErrors );
					}
					// Set up all the variables for the
					// page save.
					$data = array(
						'wpTextbox1' => $data_text,
						'wpSummary' => $wgRequest->getVal( 'wpSummary' ),
						'wpStarttime' => $wgRequest->getVal( 'wpStarttime' ),
						'wpEdittime' => $wgRequest->getVal( 'wpEdittime' ),
						'wpEditToken' => $wgUser->isLoggedIn() ? $wgUser->editToken() : EDIT_TOKEN_SUFFIX,
						'wpSave' => '',
						'action' => 'submit',
					);

					if ( $wgRequest->getCheck( 'wpMinoredit' ) ) {
						$data['wpMinoredit'] = true;
					}
					if ( $wgRequest->getCheck( 'wpWatchthis' ) ) {
						$data['wpWatchthis'] = true;
					}

					$request = new FauxRequest( $data, true );

					// Find existing article if it exists,
					// or create a new one.
					$article = new Article( $target_title, 0 );

					$editor = new EditPage( $article );
					$editor->importFormData( $request );

					// Try to save the page!
					$resultDetails = array();
					$saveResult = $editor->internalAttemptSave( $resultDetails );
					// Return value was made an object in MW 1.19
					if ( is_object( $saveResult ) ) {
						$saveResultCode = $saveResult->value;
					} else {
						$saveResultCode = $saveResult;
					}

					if ( ( $saveResultCode == EditPage::AS_HOOK_ERROR || $saveResultCode == EditPage::AS_HOOK_ERROR_EXPECTED ) && $redirectOnError ) {

						$wgOut->clearHTML();
						$wgOut->setArticleBodyOnly(true);
						// Lets other code process additional form-definition syntax
						wfRunHooks( 'sfWritePageData', array( $form_name, $target_title, &$data_text ) );
						$text = SFUtils::printRedirectForm( $target_title, $data_text, $wgRequest->getVal( 'wpSummary' ), $save_page, $preview_page, $diff_page, $wgRequest->getCheck( 'wpMinoredit' ), $wgRequest->getCheck( 'wpWatchthis' ), $wgRequest->getVal( 'wpStarttime' ), $wgRequest->getVal( 'wpEdittime' ) );
					} else {

						if ( $saveResultCode == EditPage::AS_SUCCESS_UPDATE || $saveResultCode == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
							$wgOut->redirect( $target_title->getFullURL() );
						}

						wfProfileOut( __METHOD__ );
						return SFUtils::processEditErrors( $saveResultCode );
					}
					
				} else {
					// Lets other code process additional form-definition syntax
					wfRunHooks( 'sfWritePageData', array( $form_name, $target_title, &$data_text ) );
					$text = SFUtils::printRedirectForm( $target_title, $data_text, $wgRequest->getVal( 'wpSummary' ), $save_page, $preview_page, $diff_page, $wgRequest->getCheck( 'wpMinoredit' ), $wgRequest->getCheck( 'wpWatchthis' ), $wgRequest->getVal( 'wpStarttime' ), $wgRequest->getVal( 'wpEdittime' ) ); // extract its data
				}


			} else {
				// override the default title for this page if
				// a title was specified in the form
				if ( $form_page_title != null ) {
					if ( $target_name === '' ) {
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
				$text .= '<form name="createbox" id="sfForm" method="post" class="createbox">';
				$pre_form_html = '';
				wfRunHooks( 'sfHTMLBeforeForm', array( &$target_title, &$pre_form_html ) );
				$text .= $pre_form_html;
				$text .= $form_text;
			}
		}

		SFUtils::addJavascriptAndCSS();
		if ( ! empty( $javascript_text ) ) {
			$wgOut->addScript( '		<script type="text/javascript">' . "\n$javascript_text\n" . '</script>' . "\n" );
		}
		$wgOut->addHTML( $text );

		wfProfileOut( __METHOD__ );
		return null;
	}
}
