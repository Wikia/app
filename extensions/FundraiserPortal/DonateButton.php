<?php

class DonateButton extends UnlistedSpecialPage {
	/* Members */

	private $mSharedMaxAge = 600;
	private $mMaxAge = 600;
	
	var $templates = array( 'Ruby', 'RubyText', 'Tourmaline', 'Sapphire' );

	/* Functions */ 
	
	function __construct() {
		parent::__construct( 'DonateButton' );
	}

	function execute () {
		global $wgOut;
		$wgOut->disable();
		$this->sendHeaders();
		$js = $this->getJsOutput();
	}

	public function sharedMaxAge() {
		return $this->mSharedMaxAge();
	}   

	public function maxAge() {
		return $this->mMaxAge();
	}   

	// Set the caches 
	private function sendHeaders() {
		$smaxage = $this->sharedMaxAge();
		$maxage = $this->maxAge();
		$public = ( session_id() == '' );

		header( "Content-type: text/javascript; charset=utf-8" );
		if ( $public ) { 
			header( "Cache-Control: public, s-maxage=$smaxage, max-age=$maxage" );
		} else {
			header( "Cache-Control: private, s-maxage=0, max-age=$maxage" );
		}
	}

	public function getJsOutput() {
		global $wgFundraiserPortalTemplates;
	
		foreach( $wgFundraiserPortalTemplates as $template => $weight ) {
			$buttons[$template] = $this->getButtonText( $template );
			$styles[$template] = $this->getButtonStyle( $template );
		}

		$encButtons = json_encode( $buttons );
		$encStyles = json_encode( $styles );

		return $this->getScriptFunctions() .
			'wgFundraiserPortalButtons=' . $encButtons . ";\n" .
			'wgFundraiserPortalStyles=' . $encStyles . ";\n" .
			"wgFundraiserPortal=wgFundraiserPortalButtons[wgDonateButton];\n" .
			"wgFundraiserPortalCSS=wgFundraiserPortalStyles[wgDonateButton];\n" .
			$this->getLoaderScript();
	}

	public function getScriptFunctions() {
		global $wgFundraiserPortalTemplates;
		$text = $this->fetchTemplate( 'donateScripts.js' );
		return strtr( $text,
			array( '{{{templateWeights}}}' =>
				json_encode( $wgFundraiserPortalTemplates ) ) );
	}

	public function getLoaderScript() {
		return $this->fetchTemplate( 'loader.js' );
	}

	public function getButtonText( $template ) {
		global $wgFundraiserPortalURL;

		// Add our tracking identifiet
		$buttonUrl = $wgFundraiserPortalURL . "&utm_source=$template";

		$text = $this->fetchTemplate( "$template.tmpl" );
		
		$text = strtr( $text, array(
			'{{{buttonUrl}}}' => $buttonUrl ));
		
		// Note these are raw; no HTML translation or anything...
		$text = preg_replace_callback( '/\{\{msg:(.*?)\}\}/',
			array( $this, 'templateMessageCallback' ),
			$text );
		
		return $text;
	}
	
	public function getButtonStyle( $template ) {
		global $wgFundraiserImageUrl;

		$text = $this->fetchTemplate( "$template.css" );
		
		$text = strtr( $text, array(
			'{{{imageUrl}}}' => $wgFundraiserImageUrl ) );
		
		return $text;
	}
	
	function templateMessageCallback( $matches ) {
		return wfMsg( $matches[1] );
	}
	
	/**
	 * Read one of this extension's resource files...
	 */
	protected function fetchTemplate( $filename ) {
		$basedir = dirname( __FILE__ );
		return file_get_contents( "$basedir/Templates/$filename" );
	}
}
