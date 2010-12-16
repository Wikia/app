<?php
/**
 * @addtogroup Extensions
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Tab0',
	'author'         => 'Agbad',
	'description'    => 'Adds "0" tab, linking to the edit page of the first section of the page',
	'descriptionmsg' => 'tab0-desc',
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
