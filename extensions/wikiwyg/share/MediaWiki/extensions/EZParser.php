<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (defined('MEDIAWIKI')) {
$wgExtensionFunctions[] = 'wfEZParser';

$wgAvailableRights[] = 'ezparser';

$wgGroupPermissions['ezparser']['ezparser'] = true;

function wfEZParser() {
global $IP;
require_once( $IP.'/includes/SpecialPage.php' );

#class EZParser extends UnlistedSpecialPage
class EZParser extends SpecialPage {
	function EZParser() {
#		UnlistedSpecialPage::UnlistedSpecialPage('EZParser');
		SpecialPage::SpecialPage('EZParser');
		wfLoadExtensionMessages('Wikiwyg');
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;
		
		if (!in_array( 'ezparser', $wgUser->getRights() ) ) {
			$wgOut->setArticleRelated( false );
			$wgOut->setRobotpolicy( 'noindex,follow' );
			$wgOut->errorpage( 'nosuchspecialpage', 'nospecialpagetext' );
			return;
		}

		$this->setHeaders();

		$text = $wgRequest->getText( 'text' );

		if ( $text ) {
			$this->parseText( $text );
		}
		else{
		  $this->addForm();
		}
	}

	function parseText($text){
		#still need to make it actually parse the input.
		global $wgOut, $wgUser, $wgTitle, $wgParser, $wgAllowDiffPreview, $wgEnableDiffPreviewPreference;
		$parserOptions = ParserOptions::newFromUser( $wgUser );
		$parserOptions->setEditSection( false );
		$output = $wgParser->parse( $text, $wgTitle, $parserOptions );
		$wgOut->setArticleBodyOnly( true );
		$wgOut->addHTML($output->mText);
	}

	function addForm(){
		global $wgOut, $wgTitle;

		$action = $wgTitle->escapeLocalUrl();

		$wgOut->addHTML( <<<EOF
<form name="ezparser" action="$action" method=post>
<textarea name="text">
enter wikitext here
</textarea>
<input type="submit" name="submit" value="OK" />
</form>
EOF
		);
	}
}

SpecialPage::addPage( new EZParser );
}
} # End if(defined MEDIAWIKI)