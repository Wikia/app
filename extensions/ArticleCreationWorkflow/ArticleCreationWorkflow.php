<?php
/* 	MediaWiki ArticleCreation Extension
	Authors: Rob Moen, Benny Situ, Brandon Harris 
*/

$wgExtensionCredits['other'][] = array(
	'author' => array( 'Rob Moen', 'Benny Situ', 'Andrew Garrett', 'Ian Baker' ),
	'descriptionmsg' => 'article-creation-desc',
	'name' => 'ArticleCreationWorkflow',
	'url' => 'http://www.mediawiki.org/wiki/Article_Creation_Landing_System',
	'version' => '0.1',
	'path' => __FILE__,
);

$articleCreationDir = dirname( __FILE__ ) . '/';

/* Object model */
$wgAutoloadClasses['ArticleCreationTemplates'] = $articleCreationDir . 'includes/ArticleCreationTemplates.php';
$wgAutoloadClasses['ArticleCreationUtil'] = $articleCreationDir . 'includes/ArticleCreationUtil.php';

/* Special Pages */
$wgAutoloadClasses['SpecialArticleCreationLanding'] = $articleCreationDir . 'SpecialArticleCreationLanding.php';
$wgSpecialPages['ArticleCreationLanding'] = 'SpecialArticleCreationLanding';

/* Hooks */
$wgAutoloadClasses['ArticleCreationHooks'] = $articleCreationDir . 'ArticleCreationWorkflow.hooks.php';
$wgHooks['BeforeDisplayNoArticleText'][] = 'ArticleCreationHooks::BeforeDisplayNoArticleText';
$wgHooks['BeforeWelcomeCreation'][] = 'ArticleCreationHooks::BeforeWelcomeCreation';
$wgHooks['AlternateEdit'][] = 'ArticleCreationHooks::AlternateEdit';

$wgHooks['ResourceLoaderGetConfigVars'][] = 'ArticleCreationHooks::resourceLoaderGetConfigVars';

/* Internationalization */
$wgExtensionMessagesFiles['ArticleCreation'] = $articleCreationDir . 'ArticleCreationWorkflow.i18n.php';

/* Resources */
$acResourceTemplate = array(
	'localBasePath' => $articleCreationDir . 'modules',
	'remoteExtPath' => 'ArticleCreationWorkflow/modules'
);

$wgResourceModules['ext.articleCreation.init'] = $acResourceTemplate + array(
	'scripts' => 'ext.articleCreation.init/ext.articleCreation.init.js',
);

$wgResourceModules['ext.articleCreation.core'] = $acResourceTemplate + array (
	'styles' 	=> 'ext.articleCreation.core/ext.articleCreation.core.css',
	'scripts'	=> 'ext.articleCreation.core/ext.articleCreation.core.js',
	'dependencies' => array(
		'mediawiki.util',
		'jquery.localize',
		'user.tokens',
	),
);

$wgResourceModules['ext.articleCreation.user'] = $acResourceTemplate + array (
	'styles' 	=> 'ext.articleCreation.user/ext.articleCreation.user.css',
	'scripts'	=> 'ext.articleCreation.user/ext.articleCreation.user.js',
	'messages'  => array(
		'ac-hover-tooltip-title',
		'ac-hover-tooltip-body-create',
		'ac-hover-tooltip-body-request',
		'ac-hover-tooltip-body-draft',
		'ac-hover-tooltip-body-signup',
		'ac-hover-tooltip-body-login',
		'ac-create-warning-create',
		'ac-create-warning-wizard',
		'ac-create-button',
		'ac-create-dismiss',
		'ac-click-tip-title-create',
		'ac-create-help',
	),
	'dependencies' => array(
		'ext.articleCreation.core',
		'jquery.localize',
	),
);

/**
 * Configuration for the buttons to appear on the ArticleCreationLanding page.
 * @see ArticleCreationTemplates::formatButtons
 **/
$wgArticleCreationButtons = array(
	'anonymous' => array(
		'login' => array(
			'title' => 'ac-action-login',
			'text' => 'ac-action-login-subtitle',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-login',
			),
		),
		'signup' => array(
			'title' => 'ac-action-signup',
			'text' => 'ac-action-signup-subtitle',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-signup',
			),
		),
		'request' => array(
			'title' => 'ac-action-request',
			'text' => 'ac-action-request-subtitle-anon',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-request',
			),
		),
	),
	'logged-in' => array(
		'request' => array(
			'title' => 'ac-action-request',
			'text' => 'ac-action-request-subtitle',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-request',
			),
		),
		'draft' => array(
			'title' => 'ac-action-draft',
			'text' => 'ac-action-draft-subtitle',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-draft',
			),
		),
		'create' => array(
			'title' => 'ac-action-create',
			'text' => 'ac-action-create-subtitle',
			'tooltip' => array(
				'title' => 'ac-hover-tooltip-title',
				'text' => 'ac-hover-tooltip-body-create',
			),
			'interstitial' => <<<HTML
				<a class="mw-ac-help" href="http://www.google.com"><html:msg key="ac-create-help" /></a>
				<div class="mw-ac-tooltip-title"><html:msg key="ac-click-tip-title-create" /></div>
				<div class="mw-ac-tooltip-body">
					<div class="mw-ac-create-verbiage"><html:msg key="ac-create-warning-create" /></div>
					<div class="ac-button-wrap">
						<a class="ac-button-green ac-button ac-action-button" data-ac-action="create">
							<div class="ac-arrow ac-arrow-forward">&nbsp;</div>
							<div class="ac-button-text">
								<div class="ac-button-title"><html:msg key="ac-create-button" /></div>
								<div class="ac-button-text"></div>
							</div>
						</a>
					</div>
					<input 
						type="checkbox" 
						id="mw-ac-dismiss-create"
						class="ac-dismiss-interstitial" />
					<label for="mw-ac-dismiss-create">
						<html:msg key="ac-create-dismiss" />
					</label>
					<div style="clear: both"></div>
				</div>
HTML
		),
	),
);

$wgArticleCreationConfig = array(
	'action-url' => array(
		'draft' => '{{SCRIPT}}?title=User:{{USER}}/{{PAGE}}&action=edit',
		'create' => '{{SCRIPT}}?title={{PAGE}}&action=edit',
		'login' => '{{SCRIPT}}?title=Special:Userlogin&returnto=Special:ArticleCreationLanding/{{PAGE}}&returntoquery=' . urlencode( 'fromlogin=1' ),
		'signup' => '{{SCRIPT}}?title=Special:Userlogin/signup&returnto=Special:ArticleCreationLanding/{{PAGE}}&returntoquery=' . urlencode( 'fromsignup=1' ),
		'request' => 'http://google.com/?q={{PAGE}}'
	),
	'buttons' => $wgArticleCreationButtons,
);
