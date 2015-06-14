<?php

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'EditorSurvey',
	'author' => 'Wikia',
	'descriptionmsg' => 'editorsurvey-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EditorSurvey',
);

$dir = dirname(__FILE__) . '/';

// classes
$wgAutoloadClasses['EditorSurveyController'] =  $dir . 'EditorSurveyController.class.php';
$wgAutoloadClasses['EditorSurveyHooksHelper'] =  $dir . 'EditorSurveyHooksHelper.class.php';
$wgAutoloadClasses['WAMApiController'] = $dir . '../WAM/controllers/api/WAMApiController.class.php';

// i18n
$wgExtensionMessagesFiles['EditorSurvey'] = $dir . 'EditorSurvey.i18n.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'EditorSurveyHooksHelper::onMakeGlobalVariablesScript';

