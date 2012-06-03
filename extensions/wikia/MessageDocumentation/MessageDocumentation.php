<?php

/**
 * Displays documentation when editing i18n messages. Should only be used on messaging.wikia.com.
 *
 * @author tor@wikia-inc.com
 * @date 2012-02-23
 */

$wgHooks['EditPage::showEditForm:initial'][] = 'efDisplayMessageDocumentation';

function efDisplayMessageDocumentation( $editPage ) {
	global $wgTitle;

	if ( $wgTitle->getNamespace() != NS_MEDIAWIKI ) {
		return true;
	}

	$docTitle = Title::newFromText( $wgTitle->getBaseText() . '/qqq', NS_MEDIAWIKI );
	$docArticle = new Article( $docTitle );

	$wikitext = $docArticle->getContent();

	if ( !empty( $wikitext ) ) {
		$editPage->editFormTextBeforeContent .= Xml::openElement( 'div', array( 'class' => 'i18ndoc' ) );
		$editPage->editFormTextBeforeContent .= htmlspecialchars( $wikitext );
		$editPage->editFormTextBeforeContent .= Xml::closeElement( 'div' );
	}

	return true;
}
