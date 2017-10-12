<?php

/**
 * Email
 *
 * @author Garth Webb
 * @author James Sutterfield
 * @author Matt Klucsarits
 *
 * @date 2015-03-10
 */

$wgExtensionCredits['Email'][] = [
	'name' => 'Email',
	'author' => [
		'Garth Webb <garth@wikia-inc.com>',
		'James Sutterfield <james@wikia-inc.com>',
		'Matt Klucsarits <mattk@wikia-inc.com>',
	],
	'descriptionmsg' => 'email-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Email'
];

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['Email\EmailController'] =  $dir . 'EmailController.class.php';
$wgAutoloadClasses['Email\Helper'] =  $dir . 'EmailHelper.class.php';
$wgAutoloadClasses['Email\ImageHelper'] =  $dir . 'EmailImageHelper.class.php';
$wgAutoloadClasses['Email\ControllerException'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\EmailMobileBadges'] =  $dir . 'EmailMobileBadges.class.php';
$wgAutoloadClasses['Email\MobileApplicationsLinksGenerator'] =  $dir . 'MobileApplicationsLinksGenerator.class.php';
$wgAutoloadClasses['Email\SocialLinksGenerator'] =  $dir . 'SocialLinksGenerator.class.php';
$wgAutoloadClasses['Email\Fatal'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\Check'] =  $dir . 'EmailExceptions.class.php';
$wgAutoloadClasses['Email\Controller\ForgotPasswordController'] =  $dir . 'Controller/ForgotPasswordController.class.php';
$wgAutoloadClasses['Email\Controller\PasswordResetLinkController'] =  $dir . 'Controller/PasswordResetLinkController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageEditedOrCreatedController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageProtectedController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageUnprotectedController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageRenamedController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageDeletedController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\WatchedPageRestoredController'] =  $dir . 'Controller/WatchedPageController.class.php';
$wgAutoloadClasses['Email\Controller\ArticleCommentController'] =  $dir . 'Controller/CommentController.class.php';
$wgAutoloadClasses['Email\Controller\BlogCommentController'] =  $dir . 'Controller/CommentController.class.php';
$wgAutoloadClasses['Email\Controller\UserBlogPostController'] =  $dir . 'Controller/BlogPostController.class.php';
$wgAutoloadClasses['Email\Controller\ListBlogPostController'] =  $dir . 'Controller/BlogPostController.class.php';
$wgAutoloadClasses['Email\Controller\WallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\FollowedWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\OwnWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\ReplyWallMessageController'] =  $dir . 'Controller/WallMessageController.class.php';
$wgAutoloadClasses['Email\Controller\ForumController'] =  $dir . 'Controller/ForumController.class.php';
$wgAutoloadClasses['Email\Controller\ReplyForumController'] =  $dir . 'Controller/ForumController.class.php';
$wgAutoloadClasses['Email\Controller\WeeklyDigestController'] =  $dir . 'Controller/WeeklyDigestController.class.php';
$wgAutoloadClasses['Email\Controller\AbstractEmailConfirmationController'] =  $dir . 'Controller/EmailConfirmationController.class.php';
$wgAutoloadClasses['Email\Controller\EmailConfirmationController'] =  $dir . 'Controller/EmailConfirmationController.class.php';
$wgAutoloadClasses['Email\Controller\EmailConfirmationReminderController'] =  $dir . 'Controller/EmailConfirmationController.class.php';
$wgAutoloadClasses['Email\Controller\ConfirmationChangedEmailController'] = $dir . 'Controller/EmailConfirmationController.class.php';
$wgAutoloadClasses['Email\Controller\ReactivateAccountController'] =  $dir . 'Controller/EmailConfirmationController.class.php';
$wgAutoloadClasses['Email\Controller\CategoryAddController'] = $dir . 'Controller/CategoryAddController.class.php';
$wgAutoloadClasses['Email\Controller\FounderEditController'] =  $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderAnonEditController'] =  $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderMultiEditController'] =  $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderActiveController'] =  $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderNewMemberController'] =  $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\GenericController'] =  $dir . 'Controller/GenericController.class.php';
$wgAutoloadClasses['Email\Controller\FounderDigestController'] = $dir . 'Controller/FounderDigestController.class.php';
$wgAutoloadClasses['Email\Controller\FounderActivityDigestController'] = $dir . 'Controller/FounderDigestController.class.php';
$wgAutoloadClasses['Email\Controller\FounderPageViewsDigestController'] = $dir . 'Controller/FounderDigestController.class.php';
$wgAutoloadClasses['Email\Controller\FounderTipsController'] = $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderTipsThreeDaysController'] = $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\FounderTipsTenDaysController'] = $dir . 'Controller/FounderController.class.php';
$wgAutoloadClasses['Email\Controller\WelcomeController'] = $dir . 'Controller/WelcomeController.class.php';
$wgAutoloadClasses['Email\Controller\UserRightsChangedController'] =  $dir . 'Controller/UserRightsChangedController.class.php';
$wgAutoloadClasses['Email\Controller\UserNameChangeController'] = $dir . 'Controller/UserNameChangeController.class.php';
$wgAutoloadClasses['Email\Controller\FacebookDisconnectController'] = $dir . 'Controller/FacebookDisconnectController.class.php';
$wgAutoloadClasses['Email\Controller\DiscussionReplyController'] = $dir . 'Controller/DiscussionController.class.php';
$wgAutoloadClasses['Email\Controller\DiscussionUpvoteController'] = $dir . 'Controller/DiscussionController.class.php';
$wgAutoloadClasses['Email\SpecialSendEmailController'] = $dir . 'SpecialSendEmailController.class.php';

/**
 * special pages
 */
$wgSpecialPages[ 'SendEmail' ] =  'Email\SpecialSendEmailController';

/**
 * messages
 */

