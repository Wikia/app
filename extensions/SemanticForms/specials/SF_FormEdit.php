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
class SFFormEdit extends UnlistedSpecialPage {

	public $mTarget;
	public $mForm;
	public $mError;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'FormEdit' );
	}

	function execute( $query ) {
		$this->setHeaders();

		$this->mForm = $this->getRequest()->getText( 'form' );
		$this->mTarget = $this->getRequest()->getText( 'target' );

		// if query string did not contain these variables, try the URL
		if ( !$this->mForm && !$this->mTarget ) {
			$queryparts = explode( '/', $query, 2 );
			$this->mForm = isset( $queryparts[ 0 ] ) ? $queryparts[ 0 ] : '';
			$this->mTarget = isset( $queryparts[ 1 ] ) ? $queryparts[ 1 ] : '';
			$this->mTarget = str_replace( '_', ' ', $this->mTarget );
		}

		$alt_forms = $this->getRequest()->getArray( 'alt_form' );

		$this->printForm( $this->mForm, $this->mTarget, $alt_forms );
	}

	function printAltFormsList( $alt_forms, $target_name ) {
		$text = "";
		$fe = SpecialPageFactory::getPage( 'FormEdit' );
		$fe_url = $fe->getTitle()->getFullURL();
		$i = 0;
		foreach ( $alt_forms as $alt_form ) {
			if ( $i++ > 0 ) {
				$text .= ', ';
			}
			$altFormURL = $fe_url . '/' . rawurlencode( $alt_form ) . '/' . rawurlencode( $target_name );
			$text .= Html::element( 'a',
				array( 'href' => $altFormURL ),
				str_replace( '_', ' ', $alt_form )
			);
		}
		return $text;
	}

	function printForm( $form_name, $targetName, $alt_forms = array( ) ) {
		$out = $this->getOutput();
		$req = $this->getRequest();

		$module = new SFAutoeditAPI( new ApiMain(), 'sfautoedit' );
		$module->setOption( 'form', $form_name );
		$module->setOption( 'target', $targetName );

		if ( $req->getCheck( 'wpSave' ) || $req->getCheck( 'wpPreview' ) || $req->getCheck( 'wpDiff' ) ) {
			// If the page was submitted, form data should be
			// complete => do not preload (unless it's a partial
			// form).
			if ( $req->getCheck( 'partial' ) ) {
				$module->setOption( 'preload', true );
			} else {
				$module->setOption( 'preload', false );
			}
		} else if ( !empty( $targetName ) && Title::newFromText( $targetName )->exists ( ) ) {
			// If target page exists, do not overwrite it with
			// preload data; just preload the page's data.
			$module->setOption( 'preload', true );
		} else if ( $req->getCheck( 'preload' ) ) {
			// if page does not exist and preload parameter is set, pass that on
			$module->setOption( 'preload', $req->getText( 'preload' ) );
		} else {
			// nothing set, so do not set preload
		}

		$module->execute();

		$text = '';

		// if action was successful and action was a Save, return
		if ( $module->getStatus() === 200 ) {
			if ( $module->getAction() === SFAutoeditAPI::ACTION_SAVE ) {
				return;
			}
		} else {

			$resultData = $module->getResultData();

			if ( array_key_exists( 'errors', $resultData ) ) {

				foreach ($resultData['errors'] as $error) {
					// FIXME: This should probably not be hard-coded to WARNING but put into a setting
					if ( $error[ 'level' ] <= SFAutoeditAPI::WARNING ) {
						$text .= Html::rawElement( 'p', array( 'class' => 'error' ), $error[ 'message' ] ) . "\n";
					}
				}
			}
		}

		// Override the default title for this page if a title was
		// specified in the form.
		$result = $module->getOptions();
		$targetTitle = Title::newFromText( $result[ 'target' ] );


		// Set page title depending on whether an explicit title was
		// specified in the form definition.
		if ( array_key_exists( 'formtitle', $result ) ) {

			// set page title depending on whether the target page exists
			if ( empty( $targetName ) ) {
				$pageTitle = $result[ 'formtitle' ];
			} else {
				$pageTitle = $result[ 'formtitle' ] . ': ' . $targetName;
			}
		} elseif ( $result[ 'form' ] !== '' ) {
			// Set page title depending on whether the target page
			// exists.
			if ( empty( $targetName ) ) {
				$pageTitle = wfMessage( 'sf_formedit_createtitlenotarget', $result[ 'form' ] )->text();
			} elseif ( $targetTitle->exists() ) {
				$pageTitle = wfMessage( 'sf_formedit_edittitle', $result[ 'form' ], $targetName )->text();
			} else {
				$pageTitle = wfMessage( 'sf_formedit_createtitle', $result[ 'form' ], $targetName )->text();
			}
		} elseif ( count( $alt_forms ) > 0 ) {
			// We use the 'creating' message here, instead of
			// 'sf_formedit_createtitlenotarget', to differentiate
			// between a page with no (default) form, and one with
			// no target; in English they'll show up as
			// "Creating ..." and "Create ...", respectively.
			// Does this make any difference? Who knows.
			$pageTitle = wfMessage( 'creating', $targetName )->text();
		} elseif ( $result[ 'form' ] == '' ) {  //FIXME: This looks weird; a simple else should be enough, right?
			// display error message if the form is not specified in the URL
			$pageTitle = wfMessage( 'formedit' )->text();
			$text .= Html::element( 'p', array( 'class' => 'error' ), wfMessage( 'sf_formedit_badurl' )->text() ) . "\n";
			$out->addHTML( $text );
		}

		$out->setPageTitle( $pageTitle );
		if ( count( $alt_forms ) > 0 ) {
			$text .= '<div class="infoMessage">';
			if ( $result[ 'form' ] != '' ) {
				$text .= wfMessage( 'sf_formedit_altforms' )->escaped();
			} else {
				$text .= wfMessage( 'sf_formedit_altformsonly' )->escaped();
			}
			$text .= ' ' . $this->printAltFormsList( $alt_forms, $targetName );
			$text .= "</div>\n";
		}

		$text .= '<form name="createbox" id="sfForm" method="post" class="createbox">';
		$pre_form_html = '';
		Hooks::run( 'sfHTMLBeforeForm', array( &$targetTitle, &$pre_form_html ) );
		$text .= $pre_form_html;
		if ( isset( $result[ 'formHTML' ] ) ) {
			$text .= $result[ 'formHTML' ];
		}

		SFUtils::addFormRLModules();

		$out->addHTML( $text );

		return null;
	}

	protected function getGroupName() {
		return 'sf_group';
	}
}
