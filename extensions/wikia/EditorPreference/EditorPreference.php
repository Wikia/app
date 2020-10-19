<?php
/**
 * Allows users to set their preference of editor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'EditorPreference',
	'author'         => 'Matt Klucsarits',
	'descriptionmsg' => 'editorpreference-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EditorPreference'
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['EditorPreference'] = $dir . 'EditorPreference.class.php';

// i18n
$wgExtensionMessagesFiles['EditorPreference'] = $dir . 'EditorPreference.i18n.php';

// Hooks
$wgHooks['EditingPreferencesBefore'][] = 'EditorPreference::onEditingPreferencesBefore';
$wgHooks['SkinTemplateNavigation'][] = 'EditorPreference::onSkinTemplateNavigation';
$wgHooks['MakeGlobalVariablesScript'][] = 'EditorPreference::onMakeGlobalVariablesScript';
$wgHooks['UserProfilePageAfterGetActionButtonData'][] = 'EditorPreference::onUserProfilePageAfterGetActionButtonData';
$wgHooks['SavePreferences'][] = 'EditorPreference::onSavePreferences';
