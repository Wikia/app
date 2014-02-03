<?php

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'External Links',
	'version' => '1.1.1',
	'author' => array( 'Subfader' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:ExternalLinks',
	'descriptionmsg' => 'el-desc',
);

/**
 * Extension settings
 */
$wgELuserRight = 'rollback'; // default: edit
$wgELvalidationMode = 'cURL'; // default: none (disabled)

$wgExtensionMessagesFiles['EL'] =  dirname(__FILE__) . '/ExternalLinks.i18n.php';

$rtgIP = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ExternalLinks'] = $rtgIP . 'SpecialExternalLinks.php';

$wgSpecialPages['ExternalLinks'] = 'ExternalLinks';
$wgSpecialPageGroups['ExternalLinks'] = 'wiki';

/**
 * Output the toolbox link
 */
$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'efExternalLinksNavigation';
$wgHooks['SkinTemplateToolboxEnd'][] = 'efExternalLinksToolbox';
function efExternalLinksNavigation( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
	global $wgTitle, $wgELtoolboxLink, $wgUser, $wgELuserRight, $wgArticlePath;
	if ( $wgELtoolboxLink
	 		 && $wgUser->isAllowed( $wgELuserRight )
	 		 && $revid !== 0
	 		//$skintemplate->getTitle() buggy in MW 1.15 and below
	 		#&& $skintemplate->getTitle()->isContentPage()
	 		#&& $skintemplate->getTitle()->exists()
	 		 && $wgTitle->exists()
	 	 ) {
		$nav_urls['ELtoolboxLink'] = array(
			'text' => wfMsg( 'el-toolboxLink' ),
			//$skintemplate->makeSpecialUrl() doesn't respect beautiful URLs, problem on submitting again
			'href' => $skintemplate->makeSpecialUrl( "ExternalLinks", "do=filter&checkResponse=on&storeSession=on&pageID=" . $wgTitle->getArticleID() )
		);
	}
	return true;
}
function efExternalLinksToolbox( &$monobook ) {
	if ( isset( $monobook->data['nav_urls']['ELtoolboxLink'] ) )
		if ( $monobook->data['nav_urls']['ELtoolboxLink']['href'] == '' ) {
			?><li id="t-iscontributors"><?php echo $monobook->msg( 'el-toolboxLink' ); ?></li><?php
		} else {
			?><li id="t-contributors"><?php
				?><a href="<?php echo htmlspecialchars( $monobook->data['nav_urls']['ELtoolboxLink']['href'] ) ?>"><?php
					echo $monobook->msg( 'el-toolboxLink' );
				?></a><?php
			?></li><?php
		}
	return true;
}
