<?php

$wgExtensionCredits['specialpage'] = [
	'name' => 'Anonymous User Lookup By Email',
	'description' => 'Provides a way to get a list of users who share an email without exposing the email',
	'descriptionmsg' => 'lookupbyemail-desc'
];

$wgAutoloadClasses['UserEmailModel'] = __DIR__ . '/UserEmailModel.class.php';
$wgAutoloadClasses['SpecialLookupByEmailController'] = __DIR__ .'/SpecialLookupByEmail.class.php';

$wgExtensionMessagesFiles['LookupByEmail'] = __DIR__ . '/SpecialLookupByEmail.i18n.php';

$wgSpecialPages['LookupByEmail'] = 'SpecialLookupByEmailController';
