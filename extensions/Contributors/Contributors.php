<?php

/**
 * Special page that lists the ten most prominent contributors to an article
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Contributors',
	'version' => '1.0.1beta',
	'author' => 'Rob Church',
	'descriptionmsg' => 'contributors-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Contributors',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Contributors'] = $dir . 'Contributors.i18n.php';
$wgExtensionMessagesFiles['ContributorsAlias'] = $dir . 'Contributors.alias.php';
$wgAutoloadClasses['SpecialContributors'] = $dir . 'Contributors.page.php';
$wgSpecialPages['Contributors'] = 'SpecialContributors';
$wgSpecialPageGroups['Contributors'] = 'pages';

$wgHooks['ArticleDeleteComplete'][] = 'efContributorsInvalidateCache';
$wgHooks['ArticleSaveComplete'][] = 'efContributorsInvalidateCache';
# Good god, this is ludicrous!
$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'efContributorsNavigation';
$wgHooks['SkinTemplateToolboxEnd'][] = 'efContributorsToolbox';

/**
 * Intelligent cut-off limit; see below
 */
$wgContributorsLimit = 10;

/**
 * After $wgContributorsLimit is reach, contributors with less than this
 * number of edits to a page won't be listed in normal or inclusion lists
 */
$wgContributorsThreshold = 2;

/**
 * Invalidate the cache we saved for a given title
 *
 * @param $article Article object that changed
 */
function efContributorsInvalidateCache( &$article ) {
	global $wgMemc;
	$wgMemc->delete( wfMemcKey( 'contributors', $article->getId() ) );

	return true;
}

/**
 * Prepare the toolbox link
 *
 * @var $skintemplate SkinTemplate
 */
function efContributorsNavigation( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
	if ( $skintemplate->getTitle()->getNamespace() === NS_MAIN && $revid !== 0 )
		$nav_urls['contributors'] = array(
			'text' => wfMsg( 'contributors-toolbox' ),
			'href' => $skintemplate->makeSpecialUrl( 'Contributors', "target=" . wfUrlEncode( "{$skintemplate->thispage}" ) )
		);
	return true;
}

/**
 * Output the toolbox link
 */
function efContributorsToolbox( &$monobook ) {
	if ( isset( $monobook->data['nav_urls']['contributors'] ) )
		if ( $monobook->data['nav_urls']['contributors']['href'] == '' ) {
			?><li id="t-iscontributors"><?php echo $monobook->msg( 'contributors-toolbox' ); ?></li><?php
		} else {
			?><li id="t-contributors"><?php
				?><a href="<?php echo htmlspecialchars( $monobook->data['nav_urls']['contributors']['href'] ) ?>"><?php
					echo $monobook->msg( 'contributors-toolbox' );
				?></a><?php
			?></li><?php
		}
	return true;
}

