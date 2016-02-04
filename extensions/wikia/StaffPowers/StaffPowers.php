<?php
/**
 * Applies staff powers to select users, like unblockableness, superhuman strength and
 * general awesomeness.
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'StaffPowers',
	'author' => 'Lucas Garczewski <tor@wikia-inc.com>',
	'descriptionmsg' => 'staffpowers-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/StaffPowers',
);

$wgExtensionMessagesFiles['StaffPowers'] = dirname(__FILE__) . '/StaffPowers.i18n.php';

// Power: unblockableness
$wgHooks['BlockIp'][] = 'efPowersMakeUnblockable';

/**
 * @param Block $block
 * @param $user
 * @return bool
 */
function efPowersMakeUnblockable( $block, $user ) {
	$blockedUser = User::newFromName( $block->getRedactedName() );

	if (empty($blockedUser) || !$blockedUser->isAllowed( 'unblockable' ) ) {
		return true;
	}

	/* $wgMessageCache was removed in ME 1.18
	global $wgMessageCache;
	// hack to get IpBlock to display the message we want -- hardcoded in core code
	$replacement = wfMsgExt( 'staffpowers-ipblock-abort', array('parseinline') );
	$wgMessageCache->addMessages( array( 'hookaborted' => $replacement ) );
	*/

	wfRunHooks('BlockIpStaffPowersCancel', array($block, $user));
	return false;
}
