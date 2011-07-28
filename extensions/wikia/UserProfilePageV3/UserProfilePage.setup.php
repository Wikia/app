<?php
/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * model
 */
$app->registerClass('UserProfilePage', $dir . '/UserProfilePage.class.php');
$app->registerClass('UserIdentityBox', $dir . '/UserIdentityBox.class.php');
$app->registerClass('Interview', $dir . '/Interview.class.php');
$app->registerClass('InterviewQuestion', $dir . '/InterviewQuestion.class.php');
$app->registerClass('ImageOperationsHelper', $dir . '/ImageOperationsHelper.class.php');

/**
 * controllers
 */
$app->registerClass('UserProfilePageController', $dir . '/UserProfilePageController.class.php');
$app->registerClass('InterviewSpecialPageController', $dir . '/InterviewSpecialPageController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('Interview', 'InterviewSpecialPageController');

/**
 * hooks
 */
$app->registerHook('SkinTemplateOutputPageBeforeExec', 'UserProfilePageController', 'onSkinTemplateOutputPageBeforeExec');
$app->registerHook('SkinSubPageSubtitleAfterTitle', 'UserProfilePageController', 'onSkinSubPageSubtitleAfterTitle');
$app->registerHook('GetRailModuleSpecialPageList', 'InterviewSpecialPageController', 'onGetRailModuleSpecialPageList' );

/**
 * messages
 */
$app->registerExtensionMessageFile('UserProfilePageV3', $dir . '/UserProfilePage.i18n.php');
//register messages package for JS
//$app->registerExtensionJSMessagePackage('UPP3_modals', array('user-identity-box-about-date-*'));

/**
 * DI setup
 */
F::addClassConstructor( 'Interview', array( 'app' => $app ) );
F::addClassConstructor( 'InterviewQuestion', array( 'app' => $app ) );
F::addClassConstructor( 'UserProfilePage', array( 'app' => $app ) );
F::addClassConstructor( 'UserProfilePageController', array( 'app' => $app ) );

/**
 * extension related configuration
 */
$UPPNamespaces = array();
$UPPNamespaces[] = NS_USER;
$UPPNamespaces[] = NS_USER_TALK;

$app->getLocalRegistry()->set( 'UserProfilePageNamespaces', $UPPNamespaces );
