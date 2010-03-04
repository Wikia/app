<?php
/**
 * ListTransclusions extension
 *
 * @author Patrick Westerhoff [poke]
 */
if ( !defined( 'MEDIAWIKI' ) )
	exit( 1 );

$wgExtensionFunctions[]              = 'efListTransclusions';
$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'ListTransclusions',
	'author'         => 'Patrick Westerhoff',
	'url'            => 'http://mediawiki.org/wiki/Extension:ListTransclusions',
	'description'    => 'Lists all transcluded templates and used images of a given page',
	'descriptionmsg' => 'listtransclusions-desc',
);

/* Extension setup */
$dir                                           = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ListTransclusions']        = $dir . 'ListTransclusions_body.php';
$wgExtensionMessagesFiles['ListTransclusions'] = $dir . 'ListTransclusions.i18n.php';
$wgExtensionAliasesFiles['ListTransclusions']  = $dir . 'ListTransclusions.alias.php';
$wgSpecialPages['ListTransclusions']           = 'ListTransclusions';
$wgSpecialPageGroups['ListTransclusions']      = 'pagetools';

/**
 * SkinTemplateToolboxEnd hook
 *
 * @param $tpl Object the calling template object
 * @return boolean always true
 */
function efListTransclusionsSkinTemplateToolboxEnd ( $tpl )
{
	if( $tpl->data['notspecialpage'] )
	{
		$spTitle = SpecialPage::getTitleFor( 'ListTransclusions', $tpl->skin->thispage );
		
		echo "\n				";
		echo '<li id="t-listtransclusions"><a href="' . htmlspecialchars( $spTitle->getLocalUrl() ) . '"';
		echo $tpl->skin->tooltipAndAccesskey( 't-listtransclusions' ) . '>';
		$tpl->msg( 'listtransclusions' );
		echo "</a></li>\n";
	}
	return true;
}

/**
 * Extension initialization
 */
function efListTransclusions ()
{
	global $wgHooks;
	wfLoadExtensionMessages( 'ListTransclusions' );
	
	// Hook to add entry to the toolbox
	$wgHooks['SkinTemplateToolboxEnd'][] = 'efListTransclusionsSkinTemplateToolboxEnd';
}