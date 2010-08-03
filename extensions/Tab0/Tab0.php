<?php
/**
 * @addtogroup Extensions
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'Tab0',
	'author'         => 'Agbad',
	'description'    => 'Adds "0" tab, linking to the edit page of the first section of the page',
	'descriptionmsg' => 'tab0-desc',
	'svn-date'       => '$LastChangedDate: 2008-06-02 16:59:10 +0200 (pon, 02 cze 2008) $',
	'svn-revision'   => '$LastChangedRevision: 35722 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Tab0',
);

$wgExtensionMessagesFiles['Tab0'] = dirname( __FILE__ ) . '/Tab0.i18n.php';
$wgHooks['SkinTemplateContentActions'][] = 'showTab0';

function showTab0( $content_actions ) {
	global $wgTitle;
	if( $wgTitle->quickUserCan( 'edit' ) && $wgTitle->exists() ) {
		$content_actions['0'] = array(
			'class' => false,
			'text' => '0',
			'href' => $wgTitle->getFullURL( 'action=edit&section=0' ),
		);
	}
	return true;
}
