<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Special page which creates independent copies of articles, retaining
 * separate histories
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Duplicator',
	'version' => '1.2',
	'author' => 'Rob Church',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Duplicator',
	'description' => 'Create independent copies of articles with full edit histories',
	'descriptionmsg' => 'duplicator-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Duplicator'] = $dir . 'Duplicator.i18n.php';
$wgExtensionAliasesFiles['Duplicator'] = $dir . 'Duplicator.alias.php';
$wgAutoloadClasses['SpecialDuplicator'] = $dir . 'Duplicator.page.php';
$wgSpecialPages['Duplicator'] = 'SpecialDuplicator';
$wgExtensionFunctions[] = 'efDuplicator';

/**
 * User permissions
 */
$wgGroupPermissions['user']['duplicate'] = true;
$wgAvailableRights[] = 'duplicate';

/**
 * Pages with more than this number of revisions can't be duplicated
 */
$wgDuplicatorRevisionLimit = 250;

/**
 * Extension setup function
 */
function efDuplicator() {
	global $wgHooks;
	$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'efDuplicatorNavigation';
	$wgHooks['SkinTemplateToolboxEnd'][] = 'efDuplicatorToolbox';
}

/**
 * Build the link to be shown in the toolbox if appropriate
 */
function efDuplicatorNavigation( &$skin, &$nav_urls, &$oldid, &$revid ) {
	global $wgUser;
	$ns = $skin->mTitle->getNamespace();
	if( ( $ns === NS_MAIN || $ns === NS_TALK ) && $wgUser->isAllowed( 'duplicate' ) ) {
		wfLoadExtensionMessages( 'Duplicator' );
		$nav_urls['duplicator'] = array(
			'text' => wfMsg( 'duplicator-toolbox' ),
			'href' => $skin->makeSpecialUrl( 'Duplicator', "source=" . wfUrlEncode( "{$skin->thispage}" ) )
		);
	}
	return true;
}

/**
 * Output the toolbox link if available
 */
function efDuplicatorToolbox( &$monobook ) {
	if ( isset( $monobook->data['nav_urls']['duplicator'] ) ) {
		wfLoadExtensionMessages( 'Duplicator' );
		if ( $monobook->data['nav_urls']['duplicator']['href'] == '' ) {
			?><li id="t-isduplicator"><?php echo $monobook->msg( 'duplicator-toolbox' ); ?></li><?php
		} else {
			?><li id="t-duplicator"><?php
				?><a href="<?php echo htmlspecialchars( $monobook->data['nav_urls']['duplicator']['href'] ) ?>"><?php
					echo $monobook->msg( 'duplicator-toolbox' );
				?></a><?php
			?></li><?php
		}
	}
	return true;
}
