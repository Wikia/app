<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A special page extension that adds a special page that generates citations
 * for pages.
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Cite/Special:Cite.php Documentation
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Cite',
	'svn-date' => '$LastChangedDate: 2008-10-30 17:12:17 +0100 (czw, 30 paź 2008) $',
	'svn-revision' => '$LastChangedRevision: 42818 $',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'adds a [[Special:Cite|citation]] special page & toolbox link', // kept for b/c
	'descriptionmsg' => 'cite_article_desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Cite/Special:Cite.php'
);

$dir = dirname(__FILE__) . '/';
# Internationalisation file
$wgExtensionMessagesFiles['SpecialCite'] = $dir . 'SpecialCite.i18n.php';
$wgExtensionAliasesFiles['SpecialCite'] = $dir . 'SpecialCite.i18n.alias.php';

$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'wfSpecialCiteNav';
$wgHooks['SkinTemplateToolboxEnd'][] = 'wfSpecialCiteToolbox';

$wgSpecialPages['Cite'] = 'SpecialCite';
$wgAutoloadClasses['SpecialCite'] = $dir . 'SpecialCite_body.php';

function wfSpecialCiteNav( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
	wfLoadExtensionMessages( 'SpecialCite' );
	if ( $skintemplate->mTitle->isContentPage() && $revid !== 0 )
		$nav_urls['cite'] = array(
			'text' => wfMsg( 'cite_article_link' ),
			'href' => $skintemplate->makeSpecialUrl( 'Cite', "page=" . wfUrlencode( "{$skintemplate->thispage}" ) . "&id=$revid" )
		);

	return true;
}

function wfSpecialCiteToolbox( &$skin ) {
	wfLoadExtensionMessages( 'SpecialCite' );
	if ( isset( $skin->data['nav_urls']['cite'] ) )
		if ( $skin->data['nav_urls']['cite']['href'] == '' ) {
			?><li id="t-iscite"><?php echo $skin->msg( 'cite_article_link' ); ?></li><?php
		} else {
			?><li id="t-cite"><?php
				?><a href="<?php echo htmlspecialchars( $skin->data['nav_urls']['cite']['href'] ) ?>"><?php
					echo $skin->msg( 'cite_article_link' );
				?></a><?php
			?></li><?php
		}

	return true;
}
