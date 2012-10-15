<?php

class CustomUserloginTemplate extends UserloginTemplate {

	protected $campaign = null;

	function __construct() {
		global $wgRequest;
		parent::__construct();
		$this->campaign = CustomUserSignupHooks::getCampaign();
	}

	function msg( $str ) {
		// exists
		if( $this->campaign && wfMessage( "customusertemplate-{$this->campaign}-$str" )->exists() ) {
			$this->msgWikiCustom( "customusertemplate-{$this->campaign}-$str", true );
		} else {
			parent::msg( $str );
		}
	}

	function msgWiki( $str ) {
		// exists
		if( $this->campaign && wfMessage( "customusertemplate-{$this->campaign}-$str" )->exists() ) {
			$this->msgWikiCustom( "customusertemplate-{$this->campaign}-$str", false );
		} else {
			parent::msgWiki( $str );
		}
	}

	function msgWikiCustom( $str, $checkifplain ) {
		global $wgParser, $wgOut;

		$text = $this->translator->translate( $str );
		$parserOutput = $wgParser->parse( $text, $wgOut->getTitle(),
			$wgOut->parserOptions(), true );
		$parsedText = $parserOutput->getText();
		if( $checkifplain &&  
			( strlen(strip_tags($parsedText)) == (strlen($parsedText)-7) )) { 
				// the parser encapsulates text in <p></p> (7 chars)  If these
				// were the only chars added to the text, then it was plaintext
				echo htmlspecialchars( $text );
		} else {
			echo $parsedText;
		}
	}
	
}

class CustomUsercreateTemplate extends UsercreateTemplate {
	protected $campaign = null;

	function __construct() {
		global $wgRequest;
		parent::__construct();
		$this->campaign = CustomUserSignupHooks::getCampaign();
	}

	function msg( $str ) {
		// exists
		if( $this->campaign && wfMessage( "customusertemplate-{$this->campaign}-$str" )->exists() ) {
			$this->msgWikiCustom( "customusertemplate-{$this->campaign}-$str", true );
		} else {
			parent::msg( $str );
		}
	}

	function msgWiki( $str ) {
		// exists
		if( $this->campaign && wfMessage( "customusertemplate-{$this->campaign}-$str" )->exists() ) {
			$this->msgWikiCustom( "customusertemplate-{$this->campaign}-$str", false );
		} else {
			parent::msgWiki( $str );
		}
	}

	function msgWikiCustom( $str, $checkifplain ) {
		global $wgParser, $wgOut;

		$text = $this->translator->translate( $str );
		$parserOutput = $wgParser->parse( $text, $wgOut->getTitle(),
			$wgOut->parserOptions(), true );
		$parsedText = $parserOutput->getText();
		if( $checkifplain &&  
			( strlen(strip_tags($parsedText)) == (strlen($parsedText)-7) )) {
				// the parser encapsulates text in <p></p> (7 chars)  If these
				// were the only chars added to the text, then it was plaintext
				echo htmlspecialchars( $text );
		} else {
			echo $parsedText;
		}
	}
	
}