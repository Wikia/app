<?php
/**
 * File holding the SpecialStoryReview class that allows reviewers to moderate the submitted stories.
 *
 * @file StoryReview_body.php
 * @ingroup Storyboard
 * @ingroup SpecialPage
 *
 * @author Jeroen De Dauw
 * 
 * TODO: fix layout
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SpecialStoryReview extends SpecialPage {

	public function __construct() {
		parent::__construct( 'StoryReview', 'storyreview' );
	}

	public function execute( $language ) {
		wfProfileIn( __METHOD__ );
		
		global $wgUser, $wgOut;
		
		$wgOut->setPageTitle( wfMsg( 'storyreview' ) );
		
		if ( $this->userCanExecute( $wgUser ) ) {
			// If the user has the storyreview permission and is not blocked, show the regular output.
			$this->addOutput();
		} else {
			// If the user is not authorized, show an error.
			$this->displayRestrictionError();
		}
		
		wfProfileOut( __METHOD__ );
	}
	
	private function addOutput() {
		global $wgOut, $wgRequest, $wgJsMimeType, $wgContLanguageCode, $wgUser;
		global $egStoryboardScriptPath;
		
		efStoryboardAddJSLocalisation();
		$wgOut->addStyle( $egStoryboardScriptPath . '/storyboard.css' );
		$wgOut->includeJQuery();
		$wgOut->addScriptFile( $egStoryboardScriptPath . "/jquery/jquery.ajaxscroll.js" );
		$wgOut->addScriptFile( $egStoryboardScriptPath . '/storyboard.js' );
		// jQuery UI core and Tabs.
		$wgOut->addScriptFile( $egStoryboardScriptPath . '/jquery/jquery-ui-1.7.2.custom.min.js' );
		$wgOut->addStyle( $egStoryboardScriptPath . '/jquery/css/jquery-ui-1.7.2.custom.css' );
		
		$unpublished = htmlspecialchars( wfMsg( 'storyboard-unpublished' ) );
		$published = htmlspecialchars( wfMsg( 'storyboard-published' ) );
		$hidden = htmlspecialchars( wfMsg( 'storyboard-hidden' ) );
		
		$language = $wgRequest->getText( 'language', false );
		if ( !$language ) $language = $wgContLanguageCode;
	
		$canDelete = $wgUser->isAllowed( 'delete' ) ? 'true' : 'false';
		
	$wgOut->addHTML( <<<EOT
<div id="storyreview-tabs">
	<ul>
		<li><a href="#$unpublished" id="$unpublished-tab">$unpublished</a></li>
		<li><a href="#$published" id="$published-tab">$published</a></li>
		<li><a href="#$hidden" id="$hidden-tab">$hidden</a></li>
	</ul>
	<div id="$unpublished"></div>
	<div id="$published"></div>
	<div id="$hidden"></div>
</div>

<script type="$wgJsMimeType">
	var storyboardLanguage = "$language";
	var storyboardCanDelete = $canDelete;

	jQuery( function() {
		jQuery( "#storyreview-tabs" ).tabs();
	});
	
	jQuery('#storyreview-tabs').bind( 'tabsshow', function( event, ui ) {
		stbShowReviewBoard( jQuery( ui.panel ), ui.index );
	});
</script>	
EOT
		);
	}
}