<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A special page extension that adds a special page that generates citations
 * for pages.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Cite/Special:Cite.php Documentation
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Cite',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'descriptionmsg' => 'cite_article_desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Cite/Special:Cite.php'
);

$dir = dirname( __FILE__ ) . '/';
# Internationalisation file
$wgExtensionMessagesFiles['SpecialCite'] = $dir . 'SpecialCite.i18n.php';
$wgExtensionMessagesFiles['SpecialCiteAliases'] = $dir . 'SpecialCite.alias.php';

$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'wfSpecialCiteNav';
$wgHooks['SkinTemplateToolboxEnd'][] = 'wfSpecialCiteToolbox';

$wgSpecialPages['Cite'] = 'SpecialCite';
$wgAutoloadClasses['SpecialCite'] = $dir . 'SpecialCite_body.php';

/**
 * @param $skintemplate SkinTemplate
 * @param $nav_urls
 * @param $oldid
 * @param $revid
 * @return bool
 */
function wfSpecialCiteNav( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
	// check whether we’re in the right namespace, the $revid has the correct type and is not empty 
	// (what would mean that the current page doesn’t exist)
	if ( $skintemplate->getTitle()->isContentPage() && $revid !== 0 && !empty( $revid ) )
		$nav_urls['cite'] = array(
			'args'   => "page=" . wfUrlencode( "{$skintemplate->thispage}" ) . "&id=$revid"
		);

	return true;
}

/**
 * add the cite link to the toolbar
 *
 * @param $skin Skin
 *
 * @return bool
 */
function wfSpecialCiteToolbox( &$skin ) {
	if ( isset( $skin->data['nav_urls']['cite'] ) ) {
		echo Html::rawElement(
			'li',
			array( 'id' => 't-cite' ),
			Linker::link(
				SpecialPage::getTitleFor( 'Cite' ),
				wfMsg( 'cite_article_link' ),
				# Used message keys: 'tooltip-cite-article', 'accesskey-cite-article'
				Linker::tooltipAndAccessKeyAttribs( 'cite-article' ),
				$skin->data['nav_urls']['cite']['args']
			)
		);
	}

	return true;
}
