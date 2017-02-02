<?php

/**
 * Discussions
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

$dir = dirname( __FILE__ ) . '/';

// load classes
$wgAutoloadClasses['SpecialDiscussionsController'] = $dir . 'controllers/SpecialDiscussionsController.class.php';
$wgAutoloadClasses['EnableDiscussionsController'] = $dir . 'controllers/EnableDiscussionsController.class.php';
$wgAutoloadClasses['DiscussionsVarToggler'] = $dir . 'DiscussionsVarToggler.class.php';
$wgAutoloadClasses['DiscussionsVarTogglerException'] = $dir . 'DiscussionsVarToggler.class.php';
$wgAutoloadClasses['ThreadCreator'] = $dir . 'api/ThreadCreator.class.php';
$wgAutoloadClasses['DiscussionsActivator'] = $dir . 'api/DiscussionsActivator.class.php';
$wgAutoloadClasses['StaffWelcomePoster'] = $dir . 'maintenance/StaffWelcomePoster.class.php';

// register special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

// This will cause /wiki/Special:Forum to redirect to Discussions when Discussions
// is enabled and Forums are disabled.
if ( !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ) {
	$wgAutoloadClasses['SpecialForumRedirectController'] = $dir . 'controllers/SpecialForumRedirectController.class.php';
	$wgSpecialPages['Forum'] = 'SpecialForumRedirectController';
}

// message files
$wgExtensionMessagesFiles['SpecialDiscussions'] = $dir . 'i18n/SpecialDiscussions.i18n.php';
$wgExtensionMessagesFiles['StaffWelcomePost'] = $dir . 'i18n/StaffWelcomePost.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['vstf']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = true;
$wgGroupPermissions['staff']['specialdiscussions'] = true;


$wgHooks['WikiaSkinTopScripts'][] = 'addDiscussionJsVariable';

/**
 * MW1.19 - ResourceLoaderStartUpModule class adds more variables
 * @param array $vars JS variables to be added at the bottom of the page
 * @param OutputPage $out
 * @return bool return true - it's a hook
 */
function addDiscussionJsVariable(Array &$vars, &$scripts) {
	wfProfileIn(__METHOD__);

	$vars['wgDiscussionsApiUrl'] = F::app()->wg->DiscussionsApiUrl;

	wfProfileOut(__METHOD__);
	return true;
}

