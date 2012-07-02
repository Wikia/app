<?php

/**
 * File holding the SPSSpecialSeriesEdit class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSSpecialSeriesEdit class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSSpecialSeriesEdit extends SpecialPage {

	public function __construct() {
		parent::__construct( 'SeriesEdit' );
	}

	public function execute( $parameters ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();
		
		if ( $wgRequest->getCheck( 'wpDiff' ) ) {
			
			// no support for the diff action
			throw new SPSException( SPSUtils::buildMessage( 'spserror-diffnotsupported' ) );
			
		} elseif ( $wgRequest->getCheck( 'wpPreview' ) ) {

			// no support for the preview action
			throw new SPSException( SPSUtils::buildMessage( 'spserror-previewnotsupported' ) );
			
		} elseif ( $wgRequest->getCheck( 'wpSave' ) ) {

			// saving requested
			$this->evaluateForm( $wgRequest );
			
		} elseif ( isset( $_SESSION ) && count( $_SESSION ) > 0 && isset( $_SESSION['spsForm'] ) && isset( $_SESSION['spsResult'] ) ) {

			// cookies enabled and result data stored
			$this->printSuccessPage( $_SESSION['spsForm'], $_SESSION['spsResult'], $_SESSION['spsOrigin'] );
			
			
			unset( $_SESSION['spsForm'] );
			unset( $_SESSION['spsResult'] );
			unset( $_SESSION['spsOrigin'] );
			
		} elseif ( ( !isset( $_SESSION ) || count( $_SESSION ) ) && count( $_GET ) === 2 ) {

			// cookies disabled, try getting result data from URL
			
			$get = $_GET;
			unset( $get['title'] );
			$get = array_keys($get);
			$get = explode( ';', $get[0], 3);
			
			$this->printSuccessPage( $get[0], $get[1], $get[2] );
						
		} else {

			// no action requested, show form
			$this->printForm( $parameters, $wgRequest );
		}
	}

	private function printForm( &$parameters, WebRequest &$request ) {

		global $wgOut, $sfgFormPrinter;

		// Prepare parameters for SFFormPrinter::formHTML
		// there is no ONE target page
		$targetTitle = null;

		// formDefinition
		$formName = $request->getText( 'form' );

		// if query string did not contain these variables, try the URL
		if ( $formName === '' ) {
			$queryparts = explode( '/', $parameters );
			$formName = isset( $queryparts[0] ) ? $queryparts[0] : null;

			// if the form name wasn't in the URL either, throw an error
			if ( is_null( $formName ) || $formName === '' ) {
				throw new SPSException( SPSUtils::buildMessage( 'spserror-noformname' ) );
			}
		}

		$formTitle = Title::makeTitleSafe( SF_NS_FORM, $formName );

		if ( !$formTitle->exists() ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-formunknown', $formName ) );
		}

		$formArticle = new Article( $formTitle );
		$formDefinition = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $formArticle->getContent() );

		// formSubmitted
		$formSubmitted = false;

		// pageContents
		$pageContents = null;

		// get 'preload' query value, if it exists
		if ( $request->getCheck( 'preload' ) ) {
			$pageContents = SFFormUtils::getPreloadedText( $request->getVal( 'preload' ) );
		} else {
			// let other extensions preload the page, if they want
			wfRunHooks( 'sfEditFormPreloadText', array(&$pageContents, $targetTitle, $formTitle) );
		}

		// pageIsSource
		$pageIsSource = ( $pageContents != null );

		// pageNameFormula
		// parse the form to see if it has a 'page name' value set
		$matches;
		if ( preg_match( '/{{{info.*page name\s*=\s*(.*)}}}/m', $formDefinition, $matches ) ) {
			$pageNameElements = SFUtils::getFormTagComponents( $matches[1] );
			$pageNameFormula = $pageNameElements[0];
		} else {
			return 'sf_formedit_badurl';
		}

		// get the iterator parameters
		$iteratorData = $this->buildIteratorParameters( $request );

		// Call SFFormPrinter::formHTML
		list ( $formText, $javascriptText, $dataText, $formPageTitle, $generatedPageName ) =
			$sfgFormPrinter->formHTML( $formDefinition, $formSubmitted, $pageIsSource, $formArticle->getID(), $pageContents, '', $pageNameFormula );

		// Set Special page main header;
		// override the default title for this page if a title was specified in the form
		if ( $formPageTitle != null ) {
			$wgOut->setPageTitle( $formPageTitle );
		} else {
			$wgOut->setPageTitle( SPSUtils::buildMessage( 'sf_formedit_createtitlenotarget', $formTitle->getText() ) );
		}

		$preFormHtml = '';
		wfRunHooks( 'sfHTMLBeforeForm', array(&$targetTitle, &$preFormHtml) );

		$text = '<form name="createbox" id="sfForm" action="" method="post" class="createbox">'
			. $preFormHtml
			. "\n"
			. SFFormUtils::hiddenFieldHTML( 'iteratordata', $iteratorData )
			. $formText;

		SFUtils::addJavascriptAndCSS();

		if ( !empty( $javascriptText ) ) {
			$wgOut->addScript( '		<script type="text/javascript">' . "\n$javascriptText\n" . '</script>' . "\n" );
		}

		$wgOut->addHTML( $text );

		return null;
	}

	private function evaluateForm( WebRequest &$request ) {

		global $wgOut, $wgUser, $spsgIterators;

		$requestValues = $_POST;

		if ( array_key_exists( 'iteratordata', $requestValues ) ) {
			$iteratorData = FormatJson::decode( $requestValues['iteratordata'], true );
			unset( $requestValues['iteratordata'] );
		} else {
			throw new SPSException(  SPSUtils::buildMessage( 'spserror-noiteratordata' ) );
		}

		$iteratorName = null;
		$targetFormName = null;
		$targetFieldName = null;
		$originPageId = null;

		foreach ( $iteratorData as $param => $value ) {

			switch ( $param ) {
				case 'iterator':
					// iteratorName
					$iteratorName = $value;
					break;
				case 'target_form':
					$targetFormName = $value;
					break;
				case 'target_field':
					$targetFieldName = $value;
					break;
				case 'origin':
					$originPageId = $value;
					break;
				default :
					$iteratorParams[$param] = $this->getAndRemoveFromArray( $requestValues, $value );
			}			
		}

		if ( is_null( $iteratorName ) || $iteratorName === '' ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-noiteratorname' ) );
		}

		if ( !array_key_exists( $iteratorName, $spsgIterators ) ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-iteratorunknown', $iteratorName ) );
		}

		// iterator
		$iterator = new $spsgIterators[$iteratorName];

		$iteratorValues = $iterator->getValues( $iteratorParams );
		$iteratorValuesCount = count( $iteratorValues );
		$userlimit = $this->getPageGenerationLimit();
		
		// check userlimit
		if ( $iteratorValuesCount > $userlimit ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-pagegenerationlimitexeeded', $iteratorValuesCount, $userlimit ) );
		}
		
		$targetFormTitle = Title::makeTitleSafe( SF_NS_FORM, $targetFormName );
		$targetFormPageId = $targetFormTitle->getArticleID();
		
		$requestValues['user'] = $wgUser->getId();

		foreach ( $iteratorValues as $value ) {
			SFAutoeditAPI::addToArray( $requestValues, $targetFieldName, $value, true );
			wfDebugLog( 'sps', 'Insert SPSPageCreationJob' );
			$job = new SPSPageCreationJob( $targetFormTitle, $requestValues );
			$job->insert();
		}
		
		// if given origin page does not exist use Main page
		if ( Title::newFromID( $originPageId ) === null ) {
			$originPageId = Title::newMainPage()->getArticleID();
		}
		
		if ( isset( $_SESSION ) ) {
			// cookies enabled
			$request->setSessionData( 'spsResult', $iteratorValuesCount );
			$request->setSessionData( 'spsForm', $targetFormPageId );
			$request->setSessionData( 'spsOrigin', $originPageId );
			header( 'Location: ' . $this->getTitle()->getFullURL() );
		} else {

			// cookies disabled, write result data to URL
			header( 'Location: ' . $this->getTitle()->getFullURL() . "?$targetFormPageId;$iteratorValuesCount;$originPageId" );
		}

		return null;
	}

	private function printSuccessPage( $formId, $createdPages, $originId ) {
		global $wgOut;

		$originTitle = Title::newFromID( $originId );
				
		$wgOut->setPageTitle( SPSUtils::buildMessage( 'spssuccesstitle', Title::newFromID( $formId )->getText() ));
		$wgOut->addHTML(
			Html::rawElement( 'p', array( 'class' => 'spssuccess' ), SPSUtils::buildMessage( 'spssuccess', $createdPages ) ) .
			Html::rawElement( 'p', array( 'class' => 'spssuccess-returntoorigin' ), SPSUtils::buildMessage(
					'spssuccess-returntoorigin', '[[' . $originTitle->getPrefixedText() . ']]'
				)
			)
		);
	}

	/**
	 * Builds a JSON blob of the data required to use the iterator.
	 * @param WebRequest $request
	 * @return type 
	 */
	private function buildIteratorParameters( WebRequest &$request ) {

		global $spsgIterators;

		// iteratorName
		$iteratorName = $request->getVal( 'iterator' );

		if ( is_null( $iteratorName ) ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-noiteratorname' ) );
		}

		if ( !array_key_exists( $iteratorName, $spsgIterators ) ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-iteratorunknown', $iteratorName ) );
		}

		// iterator
		$iterator = new $spsgIterators[$iteratorName];

		// targetFormName
		$targetFormName = $request->getVal( 'target_form' );

		if ( is_null( $targetFormName ) ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-notargetformname' ) );
		}

		// targetFormTitle is not really needed at this stage,
		// but we throw an error early if it does not exist
		$targetFormTitle = Title::makeTitleSafe( SF_NS_FORM, $targetFormName );

		if ( !$targetFormTitle->exists() ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-formunknown', $targetFormName ) );
		}

		// targetFieldName
		$targetFieldName = $request->getVal( 'target_field' );

		if ( is_null( $targetFieldName ) ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-notargetfieldname' ) );
		}

		$params = array(
			'iterator' => $iteratorName,
			'target_form' => $targetFormName,
			'target_field' => $targetFieldName,
			'origin' => $request->getVal( 'origin' )
		);

		// add the iterator-specific values
		$paramNames = $iterator->getParameterNames();
		$errors = '';

		foreach ( $paramNames as $paramName => $paramOptional ) {

			$param = $request->getVal( $paramName );

			if ( is_null( $param )  ) {
				
				if ( $paramOptional === SPS_MANDATORY) {
					// mandatory parameter missing
					$errors .= "* $paramName\n";
				}
				
			} else {
				$params[$paramName] = $param;
			}
		}

		if ( $errors !== '' ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-iteratorparammissing', $errors ) );
		}

		return FormatJson::encode( $params );
	}

	/**
	 * This function recursively retrieves a value from an array of arrays and deletes it.
	 * $key identifies path.
	 * Format: 1stLevelName[2ndLevel][3rdLevel][...], i.e. normal array notation
	 * $toplevel: if this is a toplevel value.
	 *
	 * @param type $array
	 * @param type $key
	 * @param type $toplevel 
	 */
	private function getAndRemoveFromArray( &$array, $key, $toplevel = true ) {

		$matches = array();

		if ( array_key_exists( $key, $array ) ) {
			$value = $array[$key];
			unset( $array[$key] );
			return $value;
		} elseif ( preg_match( '/^([^\[\]]*)\[([^\[\]]*)\](.*)/', $key, $matches ) ) {

			// for some reason toplevel keys get their spaces encoded by MW.
			// We have to imitate that.
			// FIXME: Are there other cases than spaces?
			if ( $toplevel ) {
				$key = str_replace( ' ', '_', $matches[1] );
			} else {
				$key = $matches[1];
			}

			if ( !array_key_exists( $key, $array ) ) {
				return null;
			}

			$value = $this->getAndRemoveFromArray( $array[$key], $matches[2] . $matches[3], false );

			if ( empty( $array[$key] ) ) {
				unset( $array[$key] );
			}

			return $value;
		} else {
			// key not found in array
			return null;
		}
	}

	public function getPageGenerationLimit() {
		global $wgUser, $spsgPageGenerationLimits;
		
		$limit = 0;
		$groups = $wgUser->getEffectiveGroups();
		
		foreach ( $groups as $group ) {
			if ( array_key_exists( $group, $spsgPageGenerationLimits) ) {
				$limit = max($limit, $spsgPageGenerationLimits[$group]);
			}
		}
		
		return $limit;
	}
	
}
