<?php
/**
 * Special:PrefSwitch
 *
 * @file
 * @ingroup Extensions
 */

class SpecialSimpleSurvey extends SpecialPage {

	/* Private Members */

	private $origin = '';
	private $originTitle = null;
	private $originQuery = '';
	private $originLink = '';
	private $originLinkUrl = '';
	private $originFullUrl = '';
	private $tokenToCheck = '';

	/* Functions */

	/**
	 * Quick token matching wrapper for form processing
	 */
	public function checkToken() {
		global $wgRequest;
		$this->tokenToCheck = $_SESSION['wsSimpleSurveyToken'];
		if ( $this->tokenToCheck != "" &&
			 ( $wgRequest->getVal( 'token' ) == $this->tokenToCheck ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function setToken() {
		$this->tokenToCheck = wfGenerateToken( array( $this, time() ) );
		wfSetupSession();
		$_SESSION['wsSimpleSurveyToken'] = $this->tokenToCheck;
	}

	public function __construct() {
		parent::__construct( 'SimpleSurvey' );
	}


	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgPrefSwitchSurveys, $wgPrefSwitchStyleVersion, $wgValidSurveys, $wgSimpleSurveyRedirectURL;
		$this->setHeaders();
		// Set page title
		$wgOut->setPageTitle( wfMsg( 'simple-survey-title' )  );
		$surveyName = $wgRequest->getVal( "survey" );

		if ( $wgRequest->wasPosted() ) {
				if ( $surveyName && in_array( $surveyName, $wgValidSurveys ) && $this->checkToken() ) {
					SimpleSurvey::save( $surveyName, $wgPrefSwitchSurveys[$surveyName] );
					$wgOut->addHtml( '<strong class="simplesurvey-success">' . wfMsgHtml( 'simple-survey-confirm' ) . '</strong>' );
				}
					// forward to new page
				if ( $wgSimpleSurveyRedirectURL ) {
					$wgOut->redirect( $wgSimpleSurveyRedirectURL );
				}

				return;
		}

		$this->setToken();
		// Get the origin from the request
		$par = $wgRequest->getVal( 'from', $par );
		$this->originTitle = Title::newFromText( $par );
		// $this->originTitle should never be Special:Userlogout
		if (
			$this->originTitle &&
			$this->originTitle->isSpecial( 'Userlogout' )
		) {
			$this->originTitle = null;
		}
		// Get some other useful information about the origin
		if ( $this->originTitle ) {
			$this->origin = $this->originTitle->getPrefixedDBKey();
			$this->originQuery = $wgRequest->getVal( 'fromquery' );
			$this->originLink = $wgUser->getSkin()->link( $this->originTitle, null, array(), $this->originQuery );
			$this->originLinkUrl = $this->originTitle->getLinkUrl( $this->originQuery );
			$this->originFullUrl = $this->originTitle->getFullUrl( $this->originQuery );
		}

		// Begin output
		$this->setHeaders();
		
		global $wgExtensionAssetsPath, $wgSimpleSurveyJSPath, $wgSimpleSurveyCSSPath;
		$script = Html::linkedScript( wfAppendQuery( $wgSimpleSurveyJSPath ? $wgSimpleSurveyJSPath :
			"$wgExtensionAssetsPath/PrefSwitch/modules/ext.prefSwitch.js", $wgPrefSwitchStyleVersion ) );
		$wgOut->addScript( $script );
		$wgOut->addExtensionStyle( wfAppendQuery( $wgSimpleSurveyCSSPath ? $wgSimpleSurveyCSSPath :
			"$wgExtensionAssetsPath/PrefSwitch/modules/ext.prefSwitch.css", $wgPrefSwitchStyleVersion ) );
		
		// Handle various modes
		$renderedSurvey = $this->render( $wgRequest->getVal( "survey" ) );

		$wgOut->addHtml( '<div class="plainlinks">' );
		$wgOut->addHtml( $renderedSurvey );
		$wgOut->addHtml( '</div>' );
		
		// Handle raw mode
		// Only output the <form> and the <script>
		if ( $wgRequest->getBool( 'raw' ) ) {
			$wgOut->disable();
			echo $renderedSurvey . $script;
		}
	}

	/* Private Functions */

	private function render( $mode = null ) {
		global $wgUser, $wgOut, $wgPrefSwitchSurveys, $wgValidSurveys;
		// Make sure links will retain the origin
		$query = array(	'from' => $this->origin, 'fromquery' => $this->originQuery );

		if ( !isset( $wgPrefSwitchSurveys[$mode] )  && !in_array( $mode, $wgValidSurveys ) ) {
			$wgOut->addWikiMsg( "simple-survey-invalid" );
			if ( $this->originTitle ) {
				$wgOut->addHTML( wfMsg( "simple-survey-back", $this->originLink ) );
			}
			return;
		}

		if ( isset( $wgPrefSwitchSurveys[$mode]['intro-msg'] ) ) {
			$wgOut->addWikiMsg( $wgPrefSwitchSurveys[$mode]['intro-msg'] );
		}

		// Setup a form
		$html = Xml::openElement(
			'form', array(
				'method' => 'post',
				'action' => $this->getTitle()->getLinkURL( $query ),
				'class' => 'simple-survey',
				'id' => "simple-survey-{$mode}"
			)
		);
		$html .= Html::Hidden( 'survey', $mode );
		$html .= Html::Hidden( 'token', $this->tokenToCheck );
		// Render a survey
		$html .= SimpleSurvey::render(
			$mode,
			$wgPrefSwitchSurveys[$mode]['questions']
		);
		// Finish out the form
		$html .= Xml::openElement( 'dt', array( 'class' => 'prefswitch-survey-submit' ) );
		$html .= Xml::submitButton(
			wfMsg( $wgPrefSwitchSurveys[$mode]['submit-msg'] ),
			array( 'id' => "simple-survey-submit-{$mode}", 'class' => 'prefswitch-survey-submit' )
		);
		$html .= Xml::closeElement( 'dt' );
		$html .= Xml::closeElement( 'form' );
		return $html;
	}
}
