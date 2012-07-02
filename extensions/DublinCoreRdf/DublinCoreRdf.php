<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DublinCoreRdf',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DublinCoreRdf',
	'author' => 'Evan Prodromou',
	'descriptionmsg' => "dublincorerdf-desc"
);

$wgHooks['MediaWikiPerformAction'][] = 'efDublinCoreBeforePageDisplay';
$wgHooks['BeforePageDisplay'][] = 'efCreativeCommonsRdfBeforePageDisplay';

$wgAutoloadClasses['DublinCoreRdf'] = $dir . 'DublinCoreRdf_body.php';

function efDublinCorePerformAction( $output, $article, $title, $user, $request, $mediaWiki ) {
	if ( $mediaWiki->getAction() !== 'dublincore' ) {
		return true;
	}

	$rdf = new DublinCoreRdf( $article );
	$rdf->show();
	return false;
}

/**
 * @param $out OutputPage
 * @param $skin Skin
 * @return bool
 */
function efDublinCoreBeforePageDisplay( $out, $skin ) {
	$out->addHeadItem( 'dublincore',
						Html::element( 'link', array(
							'rel' => $out->getMetadataAttribute(),
							'title' => 'Dublin Core',
							'type' => 'application/rdf+xml',
							'href' => $out->getTitle()->getLocalURL( 'action=dublincore' ) )
						));
	return true;
}