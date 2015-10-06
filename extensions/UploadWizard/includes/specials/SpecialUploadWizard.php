<?php
/**
 * Special:UploadWizard
 *
 * Easy to use multi-file upload page.
 *
 * @file
 * @ingroup SpecialPage
 * @ingroup Upload
 */

class SpecialUploadWizard extends SpecialPage {
	// the HTML form without javascript
	private $simpleForm;
	
	/**
	 * The name of the upload wizard campaign, or null when none is specified.
	 * 
	 * @since 1.2
	 * @var string|null
	 */
	protected $campaign = null;

	// $request is the request (usually wgRequest)
	// $par is everything in the URL after Special:UploadWizard. Not sure what we can use it for
	public function __construct( $request = null, $par = null ) {
		parent::__construct( 'UploadWizard', 'upload' );

		// create a simple form for non-JS fallback, which targets the old Special:Upload page.
		// at some point, if we completely subsume its functionality, change that to point here again,
	 	// but then we'll need to process non-JS uploads in the same way Special:Upload does.
		$this->simpleForm = new UploadWizardSimpleForm();
		$this->simpleForm->setTitle(
			SpecialPage::getTitleFor( 'Upload' )
		);
	}

	/**
	 * Replaces default execute method
	 * Checks whether uploading enabled, user permissions okay,
	 * @param $subPage, e.g. the "foo" in Special:UploadWizard/foo.
	 */
	public function execute( $subPage ) {
		global $wgRequest, $wgUser;

		// side effects: if we can't upload, will print error page to wgOut
		// and return false
		if ( !( $this->isUploadAllowed() && $this->isUserUploadAllowed( $wgUser ) ) ) {
			return;
		}

		$this->setHeaders();
		$this->outputHeader();
		
		// if query string includes 'skiptutorial=true' set config variable to true
		if ( $wgRequest->getCheck( 'skiptutorial' ) ) {
			$skip = in_array( $wgRequest->getText( 'skiptutorial' ), array( '1', 'true' ) );
			UploadWizardConfig::setUrlSetting( 'skipTutorial', $skip );
		}
		
		$this->handleCampaign();

		$out = $this->getOutput();
		
		// fallback for non-JS
		$out->addHTML( '<noscript>' );
		$out->addHTML( '<p class="errorbox">' . htmlspecialchars( wfMsg( 'mwe-upwiz-js-off' ) ) . '</p>' );
		$this->simpleForm->show();
		$out->addHTML( '</noscript>' );


		// global javascript variables
		$this->addJsVars( $subPage );

		// dependencies (css, js)
		$out->addModuleStyles( 'ext.uploadWizard' );
		$out->addModules( 'ext.uploadWizard' );

		// where the uploadwizard will go
		// TODO import more from UploadWizard's createInterface call.
		$out->addHTML( self::getWizardHtml() );
	}

	/**
	 * Handles the campaign parameter.
	 * 
	 * @since 1.2
	 */
	protected function handleCampaign() {
		global $wgRequest;
		$campaignName = $wgRequest->getVal( 'campaign' );
		
		if ( $campaignName != '' ) {
			$campaign = UploadWizardCampaign::newFromName( $campaignName, false );
			
			if ( $campaign === false ) {
				$this->displayError( wfMsgExt( 'mwe-upwiz-error-nosuchcampaign', 'parsemag', $campaignName ) );
			}
			else {
				if ( $campaign->getIsEnabled() ) {
					$this->campaign = $campaignName;
				}
				else {
					$this->displayError( wfMsgExt( 'mwe-upwiz-error-campaigndisabled', 'parsemag', $campaignName ) );
				}
			}
		}
	}
	
	/**
	 * Display an error message.
	 * 
	 * @since 1.2
	 * 
	 * @param string $message
	 */
	protected function displayError( $message ) {
		$this->getOutput()->addHTML( Html::element(
			'span',
			array( 'class' => 'errorbox' ),
			$message
		) . '<br /><br /><br />' );
	}
	
	/**
	 * Adds some global variables for our use, as well as initializes the UploadWizard
	 * 
	 * TODO once bug https://bugzilla.wikimedia.org/show_bug.cgi?id=26901
	 * is fixed we should package configuration with the upload wizard instead of
	 * in uploadWizard output page. 
	 * 
	 * @param subpage, e.g. the "foo" in Special:UploadWizard/foo
	 */
	public function addJsVars( $subPage ) {
		global $wgSitename;
		
		$config = UploadWizardConfig::getConfig( $this->campaign );
		
		$labelPageContent = $this->getPageContent( $config['idFieldLabelPage'] );
		if ( $labelPageContent !== false ) {
			$config['idFieldLabel'] = $labelPageContent;
		}
		
		$config['thanksLabel'] = $this->getPageContent( $config['thanksLabelPage'], true );
		
		$defaultLicense = $this->getUser()->getGlobalPreference( 'upwiz_deflicense' );
		
		if ( $defaultLicense !== 'default' ) {
			$defaultLicense = explode( '-', $defaultLicense, 2 );
			$licenseType = $defaultLicense[0];
			$defaultLicense = $defaultLicense[1];
			
			if ( in_array( $defaultLicense, $config['licensesOwnWork']['licenses'] )
				|| in_array( $defaultLicense,  UploadWizardConfig::getThirdPartyLicenses() ) ) {
				
				$licenseGroup = $licenseType === 'ownwork' ? 'licensesOwnWork' : 'licensesThirdParty';
				$config[$licenseGroup]['defaults'] = array( $defaultLicense );
				$config['defaultLicenseType'] = $licenseType;
			}
		}
		
		$this->getOutput()->addScript( 
			Skin::makeVariablesScript( 
				array(
					'UploadWizardConfig' => $config
				) +
				// Site name is a true global not specific to Upload Wizard
				array( 
					'wgSiteName' => $wgSitename
				)
			)
		);
	}
	
	/**
	 * Gets content of the specified page, or false if there is no such page.
	 * '$1' in $pageName is replaced by the code of the current language.
	 * 
	 * @since 1.2
	 * 
	 * @param string $pageName
	 * @param boolean $parse
	 * @param string $langCode
	 * 
	 * @return string|false
	 */
	protected function getPageContent( $pageName, $parse = false, $langCode = null ) {
		$content = false;
		
		if ( trim( $pageName ) !== '' ) {
			if ( is_null( $langCode ) ) {
				$langCode = $this->getLanguage()->getCode();
			}
			
			$page = Title::newFromText( str_replace( '$1', $langCode, $pageName ) );
			
			if ( !is_null( $page ) && $page->exists() ) {
				$article = new Article( $page, 0 );
				$content = $article->getContent();
				
				if ( $parse ) {
					$content = $this->getOutput()->parse( $content );
				}
			}
		}
		
		// If no page was found, and the lang is not en, then see if there in an en version.
		if ( $content === false && $langCode != 'en' ) {
			$content = $this->getPageContent( $pageName, $parse, 'en' );
		}
		
		return $content;
	}

	/**
	 * Check if anyone can upload (or if other sitewide config prevents this)
	 * Side effect: will print error page to wgOut if cannot upload.
	 * @return boolean -- true if can upload
	 */
	private function isUploadAllowed() {
		global $wgEnableAPI;

		// Check uploading enabled
		if ( !UploadBase::isEnabled() ) {
			$this->getOutput()->showErrorPage( 'uploaddisabled', 'uploaddisabledtext' );
			return false;
		}

		// XXX does wgEnableAPI affect all uploads too?

		// Check whether we actually want to allow changing stuff
		if ( wfReadOnly() ) {
			$this->getOutput()->readOnlyPage();
			return false;
		}

		// we got all the way here, so it must be okay to upload
		return true;
	}

	/**
	 * Check if the user can upload
	 * Side effect: will print error page to wgOut if cannot upload.
	 * @param User
	 * @return boolean -- true if can upload
	 */
	private function isUserUploadAllowed( $user ) {
		global $wgGroupPermissions;

		if ( !$user->isAllowed( 'upload' ) ) {
			if ( !$user->isLoggedIn() && ( $wgGroupPermissions['user']['upload']
				|| $wgGroupPermissions['autoconfirmed']['upload'] ) ) {
				// Custom message if logged-in users without any special rights can upload
				$this->getOutput()->showErrorPage( 'uploadnologin', 'uploadnologintext' );
			} else {
				throw new  PermissionsError( 'upload' );
			}
			return false;
		}

		// Check blocks
		if ( $user->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
			return false;
		}

		// we got all the way here, so it must be okay to upload
		return true;
	}

	/**
	 * Return the basic HTML structure for the entire page
	 * Will be enhanced by the javascript to actually do stuff
	 * @return {String} html
	 */
	function getWizardHtml() {
		global $wgExtensionAssetsPath;
		
		$globalConf = UploadWizardConfig::getConfig( $this->campaign );
		
		$headerContent = $this->getPageContent( $globalConf['headerLabelPage'] );
		if ( $headerContent !== false ) {
			$this->getOutput()->addWikiText( $headerContent );
		}
		
		if ( array_key_exists( 'fallbackToAltUploadForm', $globalConf ) 
			&& array_key_exists( 'altUploadForm', $globalConf ) 
			&& $globalConf['altUploadForm'] != ''
			&& $globalConf[ 'fallbackToAltUploadForm' ] 			) {

			$linkHtml = '';
			$altUploadForm = Title::newFromText( $globalConf[ 'altUploadForm' ] );
			if ( $altUploadForm instanceof Title ) {
				$linkHtml = Html::rawElement( 'p', array( 'style' => 'text-align: center;' ), 
					Html::rawElement( 'a', array( 'href' => $altUploadForm->getLocalURL() ), 
						$globalConf['altUploadForm'] 
					) 
				);
			}

			return 	 
				Html::rawElement( 'div', array( 'id' => 'upload-wizard', 'class' => 'upload-section' ),
					Html::rawElement( 'p', array( 'style' => 'text-align: center' ), wfMsg( 'mwe-upwiz-extension-disabled' ) ) 
					. $linkHtml
				);

		}
	
		$tutorialHtml = '';
		// only load the tutorial HTML if we aren't skipping the first step
		// TODO should use user preference not a cookie ( so the user does not have to skip it for every browser )
		if ( !isset( $_COOKIE['skiptutorial'] ) && !$globalConf['skipTutorial'] ) {
			$tutorialHtml = UploadWizardTutorial::getHtml( $this->campaign );
		}
		
		// TODO move this into UploadWizard.js or some other javascript resource so the upload wizard
		// can be dynamically included ( for example the add media wizard ) 
		return 
		  '<div id="upload-wizard" class="upload-section">'

			// if loading takes > 2 seconds display spinner. Note we are evading Resource Loader here, and linking directly. Because we want an image to appear if RL's package is late.
			// using some &nbsp;'s which is a bit of superstition, to make sure jQuery will hide this (it seems that it doesn't sometimes, when it has no content)
			// the min-width & max-width is copied from the #uploadWizard properties, so in nice browsers the spinner is right where the button will go.
		.	'<div id="mwe-first-spinner" style="min-width:750px; max-width:900px; height:200px; line-height:200px; text-align:center;">'
		.	'&nbsp;<img src="' . $wgExtensionAssetsPath . '/UploadWizard/resources/images/24px-spinner-0645ad.gif" width="24" height="24" />&nbsp;'
		.	'</div>'
		
		    // the arrow steps - hide until styled
		.   '<ul id="mwe-upwiz-steps" style="display:none;">'
		.     '<li id="mwe-upwiz-step-tutorial"><div>' . wfMsg( 'mwe-upwiz-step-tutorial' ) . '</div></li>'
		.     '<li id="mwe-upwiz-step-file"><div>' . wfMsg( 'mwe-upwiz-step-file' ) . '</div></li>'
		.     '<li id="mwe-upwiz-step-deeds"><div>'  . wfMsg( 'mwe-upwiz-step-deeds' )  . '</div></li>'
		.     '<li id="mwe-upwiz-step-details"><div>'  . wfMsg( 'mwe-upwiz-step-details' )  . '</div></li>'
		.     '<li id="mwe-upwiz-step-thanks"><div>'   . wfMsg( 'mwe-upwiz-step-thanks' )  .  '</div></li>'
		.   '</ul>'

		    // the individual steps, all at once - hide until needed
		.   '<div id="mwe-upwiz-content">'

		.     '<div class="mwe-upwiz-stepdiv" id="mwe-upwiz-stepdiv-tutorial" style="display:none;">'
		.       '<div id="mwe-upwiz-tutorial">'
		.         $tutorialHtml
		.       '</div>'
		.       '<div class="mwe-upwiz-buttons">'
		.          '<input type="checkbox" id="mwe-upwiz-skip" value="1" name="skip">'
		.          '<label for="mwe-upwiz-skip">' . wfMsg('mwe-upwiz-skip-tutorial-future') . '</label>'
		.          '<button class="mwe-upwiz-button-next">' . wfMsg( "mwe-upwiz-next" )  . '</button>'
		.       '</div>'
		.     '</div>'

		.     '<div class="mwe-upwiz-stepdiv ui-helper-clearfix" id="mwe-upwiz-stepdiv-file" style="display:none;">'
		.       '<div id="mwe-upwiz-files">'
		.         '<div id="mwe-upwiz-filelist" class="ui-corner-all"></div>'
		.         '<div id="mwe-upwiz-upload-ctrls" class="mwe-upwiz-file ui-helper-clearfix">'
		.            '<div id="mwe-upwiz-add-file-container" class="mwe-upwiz-add-files-0">'
		.              '<button id="mwe-upwiz-add-file">' . wfMsg( "mwe-upwiz-add-file-0-free" ) . '</button>'
		.  	     '</div>'
		.	     '<div id="mwe-upwiz-upload-ctrl-container">'
		.		'<button id="mwe-upwiz-upload-ctrl">' . wfMsg( "mwe-upwiz-upload" ) . '</button>'
		.	     '</div>'
		.         '</div>'
		.         '<div id="mwe-upwiz-progress" class="ui-helper-clearfix"></div>'
		.         '<div id="mwe-upwiz-continue" class="ui-helper-clearfix"></div>'
		.       '</div>'
		.       '<div class="mwe-upwiz-buttons">'
		.	   '<div class="mwe-upwiz-file-next-all-ok mwe-upwiz-file-endchoice">'
		.             wfMsg( "mwe-upwiz-file-all-ok" )
		.             '<button class="mwe-upwiz-button-next">' . wfMsg( "mwe-upwiz-next-file" )  . '</button>'
		.          '</div>'
		.	   '<div class="mwe-upwiz-file-next-some-failed mwe-upwiz-file-endchoice">'
		.             wfMsg( "mwe-upwiz-file-some-failed" )
		.             '<button class="mwe-upwiz-button-retry">' . wfMsg( "mwe-upwiz-file-retry" )  . '</button>'
		.             '<button class="mwe-upwiz-button-next">' . wfMsg( "mwe-upwiz-next-file-despite-failures" )  . '</button>'
		.          '</div>'
		.	   '<div class="mwe-upwiz-file-next-all-failed mwe-upwiz-file-endchoice">'
		.             wfMsg( "mwe-upwiz-file-all-failed" )
		.             '<button class="mwe-upwiz-button-retry"> ' . wfMsg( "mwe-upwiz-file-retry" )  . '</button>'
		.          '</div>'
		.       '</div>'
		.     '</div>'

		.     '<div class="mwe-upwiz-stepdiv" id="mwe-upwiz-stepdiv-deeds" style="display:none;">'
		.       '<div id="mwe-upwiz-deeds-thumbnails" class="ui-helper-clearfix"></div>'
		.       '<div id="mwe-upwiz-deeds" class="ui-helper-clearfix"></div>'
		.       '<div id="mwe-upwiz-deeds-custom" class="ui-helper-clearfix"></div>'
		.       '<div class="mwe-upwiz-buttons">'
		.          '<button class="mwe-upwiz-button-next">' . wfMsg( "mwe-upwiz-next-deeds" )  . '</button>'
		.       '</div>'
		.     '</div>'

		.     '<div class="mwe-upwiz-stepdiv" id="mwe-upwiz-stepdiv-details" style="display:none;">'
		.       '<div id="mwe-upwiz-macro-files" class="mwe-upwiz-filled-filelist ui-corner-all"></div>'
		.       '<div class="mwe-upwiz-buttons">'
		.	   '<div id="mwe-upwiz-details-error-count" class="mwe-upwiz-file-endchoice mwe-error"></div>'
		.	   '<div class="mwe-upwiz-start-next mwe-upwiz-file-endchoice">'
		.            '<button class="mwe-upwiz-button-next">' . wfMsg( "mwe-upwiz-next-details" )  . '</button>'
		.          '</div>'
		.	   '<div class="mwe-upwiz-file-next-some-failed mwe-upwiz-file-endchoice">'
		.             wfMsg( "mwe-upwiz-file-some-failed" )
		.             '<button class="mwe-upwiz-button-retry">' . wfMsg( "mwe-upwiz-file-retry" )  . '</button>'
		.             '<button class="mwe-upwiz-button-next-despite-failures">' . wfMsg( "mwe-upwiz-next-file-despite-failures" )  . '</button>'
		.          '</div>'
		.	   '<div class="mwe-upwiz-file-next-all-failed mwe-upwiz-file-endchoice">'
		.             wfMsg( "mwe-upwiz-file-all-failed" )
		.             '<button class="mwe-upwiz-button-retry"> ' . wfMsg( "mwe-upwiz-file-retry" )  . '</button>'
		.          '</div>'
		.       '</div>'
		.     '</div>'

		.     '<div class="mwe-upwiz-stepdiv" id="mwe-upwiz-stepdiv-thanks" style="display:none;">'
		.       '<div id="mwe-upwiz-thanks"></div>'
		.       '<div class="mwe-upwiz-buttons">'
		.          '<button class="mwe-upwiz-button-home">' . wfMsg( "mwe-upwiz-home" ) . '</button>'
		.          '<button class="mwe-upwiz-button-begin">' . wfMsg( "mwe-upwiz-upload-another" )  . '</button>'
		.       '</div>'
		.     '</div>'

		.   '</div>'

		.   '<div class="mwe-upwiz-clearing"></div>'

		. '</div>';
	}

}


/**
 * This is a hack on UploadForm, to make one that works from UploadWizard when JS is not available.
 */
class UploadWizardSimpleForm extends UploadForm {

	/*
 	 * Normally, UploadForm adds its own Javascript.
 	 * We wish to prevent this, because we want to control the case where we have Javascript.
 	 * So, we make the addUploadJS a no-op.
	 */
	protected function addUploadJS( ) { }

}


