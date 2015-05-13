<?php

/**
 * Email
 *
 * @author Garth Webb
 *
 * @date 2015-03-10
 */

$wgExtensionCredits['Email'][] = [
	'name' => 'Email',
	'author' => [
		"Garth Webb <garth@wikia-inc.com>"
	],
	'descriptionmsg' => 'email-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Email'
];

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['Email\EmailController'] =  $dir . 'EmailController.class.php';
$wgAutoloadClasses['Email\ImageHelper'] =  $dir . 'EmailImageHelper.class.php';
$wgAutoloadClasses['Email\ControllerException'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\Fatal'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\Check'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\Controller\ForgotPasswordController'] =  $dir . 'Controller/UserLogin.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\ArticleCommentController'] =  $dir . 'Controller/CommentController.class.php';
$wgAutoloadClasses['Email\Controller\BlogCommentController'] =  $dir . 'Controller/CommentController.class.php';
$wgAutoloadClasses['Email\Controller\WallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\FollowedWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\OwnWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\ReplyWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';

/**
 * messages
 */
$wgExtensionMessagesFiles['Email'] = $dir . 'Email.i18n.php';
$wgExtensionMessagesFiles['WatchedPage'] = $dir . 'i18n/WatchedPage.i18n.php';
$wgExtensionMessagesFiles['Comment'] = $dir . 'i18n/Comment.i18n.php';
$wgExtensionMessagesFiles['WallMessage'] = $dir . 'i18n/WallMessage.i18n.php';
