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
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['EditorPreference'] = $dir . 'EditorPreference.class.php';

// i18n
$wgExtensionMessagesFiles['EditorPreference'] = $dir . 'EditorPreference.i18n.php';

// Hooks
$wgHooks['EditingPreferencesBefore'][] = 'EditorPreference::onEditingPreferencesBefore';
$wgHooks['SkinTemplateNavigation'][] = 'EditorPreference::onSkinTemplateNavigation';
$wgHooks['MakeGlobalVariablesScript'][] = 'EditorPreference::onMakeGlobalVariablesScript';

// Default preference
$wgDefaultUserOptions[PREFERENCE_EDITOR] = 0;