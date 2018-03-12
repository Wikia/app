<?php

$GLOBALS['wgAutoloadClasses']['AuthPagesHooks'] = __DIR__ . '/AuthPagesHooks.php';

$GLOBALS['wgAutoloadClasses']['EmailConfirmationController'] = __DIR__ . '/EmailConfirmationController.class.php';

$GLOBALS['wgAutoloadClasses']['AbstractAuthPageRedirect'] = __DIR__ . '/specials/AbstractAuthPageRedirect.php';
$GLOBALS['wgAutoloadClasses']['SpecialSignupRedirect'] = __DIR__ . '/specials/SpecialSignupRedirect.php';
$GLOBALS['wgAutoloadClasses']['SpecialUserLoginRedirect'] = __DIR__ . '/specials/SpecialUserLoginRedirect.php';
$GLOBALS['wgAutoloadClasses']['SpecialUserSignupRedirect'] = __DIR__ . '/specials/SpecialUserSignupRedirect.php';
$GLOBALS['wgAutoloadClasses']['SpecialWikiaConfirmEmailRedirect'] = __DIR__ . '/specials/SpecialWikiaConfirmEmailRedirect.php';

$GLOBALS['wgAutoloadClasses']['UserLogoutSpecialController'] = __DIR__ . '/specials/UserLogoutSpecialController.php';

$GLOBALS['wgWikiaApiControllers']['EmailConfirmationController'] = $dir . 'EmailConfirmationController.class.php';

$GLOBALS['wgSpecialPages']['Signup'] = 'SpecialSignupRedirect';
$GLOBALS['wgSpecialPages']['UserLogin'] = 'SpecialUserLoginRedirect';
$GLOBALS['wgSpecialPages']['UserSignup'] = 'SpecialUserSignupRedirect';
$GLOBALS['wgSpecialPages']['WikiaConfirmEmail'] = 'SpecialWikiaConfirmEmailRedirect';
$GLOBALS['wgSpecialPages']['Userlogout'] = 'UserLogoutSpecialController';

$GLOBALS['wgHooks']['BeforePageDisplay'][] = 'AuthPagesHooks::onBeforePageDisplay';
