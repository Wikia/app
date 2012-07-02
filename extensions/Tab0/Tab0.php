<?php
/**
 * @file
 * @ingroup Extensions
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Tab0',
	'author'         => 'Agbad',
	'descriptionmsg' => 'tab0-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Tab0',
);

$wgExtensionMessagesFiles['Tab0'] = dirname( __FILE__ ) . '/Tab0.i18n.php';
$wgHooks['SkinTemplateNavigation::Universal'][] = 'showTab0';

function showTab0( $skin, &$content_actions ) {
	$title = $skin->getTitle();
	if( $title->quickUserCan( 'edit' ) && $title->exists() ) {
		$content_actions['actions']['0'] = array(
			'class' => false,
			'text' => '0',
			'href' => $title->getFullURL( 'action=edit&section=0' ),
		);
	}
	return true;
}
