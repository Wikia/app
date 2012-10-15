<?php

if (!defined('MEDIAWIKI'))
	die;

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Preview',
	'author'         => '',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Preview',
);

$wgSpecialPages['Preview'] = 'SpecialPreview';

class SpecialPreview extends SpecialPage {
	function __construct() {
		parent::__construct( 'Preview' );
	}

	function execute( $subpage ) {
		global $wgRequest, $wgOut;

		$wgOut->setPageTitle( 'Wikitext Preview' );

		if ( $wikitext = $wgRequest->getText( 'wikitext' ) ) {
			$wgOut->addHTML( Xml::fieldset( 'Wikitext preview', $wgOut->parse( $wikitext ) ) );
		}

		$f = Xml::textarea( 'wikitext', $wikitext );
		$f .= Xml::submitButton( 'Preview wikitext' );

		$f .= Html::Hidden( 'title', $this->getTitle()->getPrefixedText() );
		$f = Xml::tags( 'form', array( 'method' => 'POST', 'action' => $this->getTitle()->getLocalURL() ), $f );

		$wgOut->addHTML( Xml::fieldset( 'Preview wikitext', $f ) );
	}
}
